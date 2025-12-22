<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\ClassSessionType;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Transaction\Transaction;

class GenerateClassSessionsForMonth extends Command
{
    protected $signature = 'classes:generate-sessions {--month=}';

    protected $description = 'Generate class sessions for each classroom for the given month (defaults to current month)';

    public function handle(): int
    {
        $monthOption = $this->option('month');
        if ($monthOption) {
            try {
                $monthStart = Carbon::createFromFormat('Y-m', $monthOption)->startOfMonth();
            } catch (\Throwable $e) {
                $this->error('Invalid --month format. Use YYYY-MM');
                return self::FAILURE;
            }
        } else {
            // By default, generate for the current month when the command runs on the 1st
            $monthStart = Carbon::now()->startOfMonth();
        }
        $monthEnd = (clone $monthStart)->endOfMonth()->endOfDay();

        $this->info('Generating sessions for: '.$monthStart->format('F Y'));

        $classrooms = Classroom::query()
            ->whereNotNull('instructor_id')
            ->whereNotNull('class_session_type_id')
            ->get();

        $generatedCount = 0;

        foreach ($classrooms as $classroom) {
            $perWeek = (int) $classroom->repeats_per_week;
            if ($perWeek <= 0) { continue; }

            // Count existing sessions in the target month for idempotency
            $existing = ClassSession::query()
                ->where('classroom_id', $classroom->id)
                ->whereBetween('held_at', [$monthStart->copy()->startOfDay(), $monthEnd])
                ->orderBy('held_at')
                ->get()
                ->pluck('held_at')
                ->map(fn($dt) => Carbon::parse($dt)->toDateTimeString())
                ->toArray();

            // Determine days/time preferences
            $daysCsv = (string) $classroom->days_of_week;
            $days = array_values(array_filter(array_map('intval', explode(',', $daysCsv)), fn($v) => $v >= 1 && $v <= 7));
            $sessionTime = $classroom->session_time ?: '10:00:00';

            $targetDates = $this->generateDatesForMonth($monthStart, $perWeek, $days, $sessionTime);

            $datesToCreate = array_values(array_filter($targetDates, function (Carbon $dt) use ($existing) {
                return !in_array($dt->toDateTimeString(), $existing, true);
            }));

            if (empty($datesToCreate)) {
                $this->line("Classroom #{$classroom->id} already has sessions for {$monthStart->format('Y-m')}");
                continue;
            }

            DB::beginTransaction();
            try {
                foreach ($datesToCreate as $dt) {
                    $session = ClassSession::create([
                        'classroom_id' => $classroom->id,
                        'instructor_id' => $classroom->instructor_id,
                        'held_at' => $dt,
                        'content' => null,
                        'class_session_type_id' => $classroom->class_session_type_id,
                    ]);
                    $generatedCount++;

                    // Create parent transactions for this session (charge per student)
                    $type = $classroom->defaultSessionType ?? ClassSessionType::find($classroom->class_session_type_id);
                    $perStudentPrice = $type ? (float) $type->price : 0.0;
                    $typeName = $type ? $type->name : 'Session';

                    // Get enrolled students in this classroom (users.id)
                    $studentUserIds = $classroom->students()->pluck('users.id')->toArray();
                    if (!empty($studentUserIds) && $perStudentPrice > 0) {
                        foreach ($studentUserIds as $studentUserId) {
                            $student = Student::find($studentUserId);
                            if (!$student) {
                                continue;
                            }
                            $parent = $student->parentts()->first();
                            if (!$parent) {
                                continue;
                            }
                            Transaction::create([
                                'parent_id' => $parent->user_id,
                                'course_id' => 0,
                                'student_id' => $student->user_id,
                                'price' => $perStudentPrice,
                                'type' => 'once',
                                'is_credit' => 0,
                                'desc' => 'Class session #'.$session->id.' charge: '.$typeName,
                            ]);
                        }
                    }
                }
                DB::commit();
                $this->info("Created ".count($datesToCreate)." sessions for classroom #{$classroom->id}");
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->error("Failed generating sessions for classroom #{$classroom->id}: ".$e->getMessage());
            }
        }

        $this->info("Done. Generated {$generatedCount} sessions for ".$monthStart->format('F Y'));
        return self::SUCCESS;
    }

    /**
     * Generate session datetimes for each week of the month.
     * Strategy: For each ISO week overlapping the month, schedule on Monday + [0..repeats_per_week-1] days at 10:00.
     * Ensures all dates fall within the month.
     */
    private function generateDatesForMonth(Carbon $monthStart, int $repeatsPerWeek, array $daysOfWeek, string $sessionTime): array
    {
        $monthEnd = $monthStart->copy()->endOfMonth();

        // If specific days are provided, schedule on those weekdays each week at the specified time
        if (!empty($daysOfWeek)) {
            $period = CarbonPeriod::create(
                $monthStart->copy()->startOfWeek(Carbon::MONDAY),
                '1 week',
                $monthEnd->copy()->endOfWeek(Carbon::SUNDAY)
            );

            [$hh, $mm, $ss] = array_map('intval', explode(':', strlen($sessionTime) === 5 ? $sessionTime.':00' : $sessionTime));

            $results = [];
            foreach ($period as $weekStart) {
                foreach ($daysOfWeek as $isoDow) {
                    // Carbon ISO-8601: 1=Mon ... 7=Sun
                    $candidate = $weekStart->copy()->startOfWeek(Carbon::MONDAY)->addDays($isoDow - 1)->setTime($hh, $mm, $ss);
                    if ($candidate->betweenIncluded($monthStart, $monthEnd)) {
                        $results[] = $candidate;
                    }
                }
            }

            // Sort and unique
            usort($results, fn($a, $b) => $a->getTimestamp() <=> $b->getTimestamp());
            $unique = [];
            $out = [];
            foreach ($results as $dt) {
                $key = $dt->toDateTimeString();
                if (!isset($unique[$key])) {
                    $unique[$key] = true;
                    $out[] = $dt;
                }
            }

            return $out;
        }

        // Fallback: consecutive days starting Monday at 10:00
        $period = CarbonPeriod::create($monthStart->copy()->startOfWeek(Carbon::MONDAY), '1 week', $monthEnd->copy()->endOfWeek(Carbon::SUNDAY));
        $results = [];

        foreach ($period as $weekStart) {
            // Only consider weeks that overlap the month
            $weekStart = $weekStart->copy()->startOfWeek(Carbon::MONDAY);
            $weekEnd = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);

            // For each week, pick up to repeatsPerWeek consecutive days starting Monday
            for ($i = 0; $i < $repeatsPerWeek; $i++) {
                $candidate = $weekStart->copy()->addDays($i)->setTime(10, 0, 0);
                if ($candidate->betweenIncluded($monthStart, $monthEnd)) {
                    $results[] = $candidate;
                }
            }
        }

        // Sort and unique by datetime string
        $unique = [];
        $out = [];
        foreach ($results as $dt) {
            $key = $dt->toDateTimeString();
            if (!isset($unique[$key])) {
                $unique[$key] = true;
                $out[] = $dt;
            }
        }

        return $out;
    }
}
