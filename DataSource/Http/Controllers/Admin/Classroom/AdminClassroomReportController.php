<?php

namespace DataSource\Http\Controllers\Admin\Classroom;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\Classroom\Classroom;
use DataSource\Entities\Classroom\ClassSessionType;
use DataSource\Entities\User\User;
use DataSource\Entities\Transaction\Transaction;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Student\Student;
use Carbon\Carbon;

class AdminClassroomReportController extends BaseController
{
    public function instructorTotals(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $instructorId = $request->input('instructor_id');
        $classroomId = $request->input('classroom_id');
        $typeId = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $baseQuery = function () use ($currentOrg, $startOfMonth, $endOfMonth, $instructorId, $classroomId, $typeId) {
            return ClassSession::normal()->with(['instructor', 'sessionType', 'classroom', 'classroom.students'])
                ->when($currentOrg, function ($q) use ($currentOrg) {
                    $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                        $cq->where('organization_id', $currentOrg->id);
                    });
                })
                ->when(!empty($instructorId), function ($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId);
                })
                ->when(!empty($classroomId), function ($q) use ($classroomId) {
                    $q->where('classroom_id', $classroomId);
                })
                ->when(!empty($typeId), function ($q) use ($typeId) {
                    $q->where('class_session_type_id', $typeId);
                })
                ->whereBetween('held_at', [$startOfMonth, $endOfMonth]);
        };

        // Sessions list (paginated)
        $sessions = $baseQuery()->latest('held_at')->paginate(25);

        // Totals by instructor + grand total
        $all = $baseQuery()->get();

        // Instructor payout is per-student (teacher_payout × number of students
        // billed for the session), mirroring revenue which charges full price per
        // student. Billed count comes from this month's charge transactions, with
        // a fallback to the classroom's currently-enrolled students.
        $billedCountBySession = $this->billedStudentCountBySession($startOfMonth, $endOfMonth);
        $payoutForSession = function ($s) use ($billedCountBySession) {
            $rate = (float) (optional($s->sessionType)->teacher_payout ?? 0);
            $students = (int) $billedCountBySession->get($s->id, 0);
            if ($students <= 0) {
                $students = $s->classroom ? $s->classroom->students->count() : 0;
            }
            return $rate * $students;
        };

        // Attach the computed payout to each paginated session for the view.
        $sessions->getCollection()->transform(function ($s) use ($payoutForSession) {
            $s->session_payout = $payoutForSession($s);
            return $s;
        });

        $totals = $all->groupBy('instructor_id')->map(function ($group) use ($payoutForSession) {
            return [
                'instructor' => optional($group->first())->instructor,
                'sessions_count' => $group->count(),
                'amount' => $group->sum(function ($s) use ($payoutForSession) {
                    return $payoutForSession($s);
                }),
            ];
        })->values();
        $grandTotal = $totals->sum('amount');

        // Dropdown data
        $instructorIds = ClassSession::normal()->when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->distinct()
            ->pluck('instructor_id')
            ->filter()
            ->values();
        $instructors = User::whereIn('id', $instructorIds)->orderBy('first_name')->get();
        $classrooms = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $types = ClassSessionType::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();

        return view('datasource::management.classrooms.report.instructor_totals', compact(
            'sessions',
            'totals',
            'grandTotal',
            'currentOrg',
            'month',
            'instructorId',
            'classroomId',
            'typeId',
            'instructors',
            'classrooms',
            'types'
        ));
    }

    public function profit(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $instructorId = $request->input('instructor_id');
        $classroomId = $request->input('classroom_id');
        $typeId = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $sessions = ClassSession::normal()->with(['sessionType', 'classroom', 'classroom.students', 'instructor'])
            ->when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->when(!empty($instructorId), function ($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            })
            ->when(!empty($classroomId), function ($q) use ($classroomId) {
                $q->where('classroom_id', $classroomId);
            })
            ->when(!empty($typeId), function ($q) use ($typeId) {
                $q->where('class_session_type_id', $typeId);
            })
            ->whereBetween('held_at', [$startOfMonth, $endOfMonth])
            ->get();

        $sessionIds = $sessions->pluck('id')->all();

        // Pull all transactions for month and match those referencing our sessions (by description)
        $monthlyTx = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $txBySession = $monthlyTx->filter(function ($t) {
            return is_string($t->desc) && preg_match('/Class session #(\d+)/i', $t->desc);
        })->groupBy(function ($t) {
            preg_match('/Class session #(\d+)/i', $t->desc, $m);
            return (int) $m[1];
        });

        // Revenue: sum of charges (is_credit = 0) on transactions linked to our sessions
        $revenue = collect($sessionIds)->sum(function ($sid) use ($txBySession) {
            $list = $txBySession->get($sid, collect());
            return $list->where('is_credit', 0)->sum('price');
        });

        // Payout is per-student: teacher_payout × number of students billed for the
        // session (mirrors revenue, which charges full price per student). Billed
        // count comes from this session's charge transactions, falling back to the
        // classroom's currently-enrolled students when no charges exist.
        $payoutForSession = function ($s) use ($txBySession) {
            $rate = (float) (optional($s->sessionType)->teacher_payout ?? 0);
            $students = $txBySession->get($s->id, collect())->where('is_credit', 0)->count();
            if ($students <= 0) {
                $students = $s->classroom ? $s->classroom->students->count() : 0;
            }
            return $rate * $students;
        };

        // Payouts: sum per-student teacher payout for the sessions
        $payouts = $sessions->sum(function ($s) use ($payoutForSession) {
            return $payoutForSession($s);
        });

        $profit = $revenue - $payouts;

        // Breakdown by classroom
        $byClassroom = $sessions->groupBy('classroom_id')->map(function ($group) use ($txBySession, $payoutForSession) {
            $sessionIds = $group->pluck('id');
            $revenue = $sessionIds->sum(function ($sid) use ($txBySession) {
                $list = $txBySession->get($sid, collect());
                return $list->where('is_credit', 0)->sum('price');
            });
            $payouts = $group->sum(function ($s) use ($payoutForSession) {
                return $payoutForSession($s);
            });
            return [
                'classroom' => optional($group->first())->classroom,
                'sessions_count' => $group->count(),
                'revenue' => $revenue,
                'payouts' => $payouts,
                'profit' => $revenue - $payouts,
            ];
        })->values();

        // Breakdown by type
        $byType = $sessions->groupBy('class_session_type_id')->map(function ($group) use ($txBySession, $payoutForSession) {
            $sessionIds = $group->pluck('id');
            $revenue = $sessionIds->sum(function ($sid) use ($txBySession) {
                $list = $txBySession->get($sid, collect());
                return $list->where('is_credit', 0)->sum('price');
            });
            $payouts = $group->sum(function ($s) use ($payoutForSession) {
                return $payoutForSession($s);
            });
            return [
                'type' => optional($group->first())->sessionType,
                'sessions_count' => $group->count(),
                'revenue' => $revenue,
                'payouts' => $payouts,
                'profit' => $revenue - $payouts,
            ];
        })->values();

        // Dropdown data
        $instructorIds = ClassSession::normal()->when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->distinct()
            ->pluck('instructor_id')
            ->filter()
            ->values();
        $instructors = User::whereIn('id', $instructorIds)->orderBy('first_name')->get();
        $classrooms = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $types = ClassSessionType::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();

        return view('datasource::management.classrooms.report.profit', compact(
            'currentOrg',
            'month',
            'instructorId',
            'classroomId',
            'typeId',
            'revenue',
            'payouts',
            'profit',
            'byClassroom',
            'byType',
            'instructors',
            'classrooms',
            'types'
        ));
    }

    public function studentDues(Request $request)
    {
        $currentOrg = $request->attributes->get('currentOrganization');
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $studentId = $request->input('student_id');
        $parentId = $request->input('parent_id');
        $classroomId = $request->input('classroom_id');
        $typeId = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        $sessions = ClassSession::normal()->with(['classroom'])
            ->when($currentOrg, function ($q) use ($currentOrg) {
                $q->whereHas('classroom', function ($cq) use ($currentOrg) {
                    $cq->where('organization_id', $currentOrg->id);
                });
            })
            ->when(!empty($classroomId), function ($q) use ($classroomId) {
                $q->where('classroom_id', $classroomId);
            })
            ->when(!empty($typeId), function ($q) use ($typeId) {
                $q->where('class_session_type_id', $typeId);
            })
            ->whereBetween('held_at', [$startOfMonth, $endOfMonth])
            ->get();
        $sessionIds = $sessions->pluck('id')->all();

        $txQuery = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        if (!empty($studentId)) {
            $txQuery->where('student_id', $studentId);
        }
        if (!empty($parentId)) {
            $txQuery->where('parent_id', $parentId);
        }
        $monthlyTx = $txQuery->get();

        // Include all monthly transactions, but if a transaction references a session,
        // only include it when that session belongs to the current org.
        $sessionIdSet = array_flip($sessionIds);
        $filtered = $monthlyTx->filter(function ($t) use ($sessionIdSet, $currentOrg, $classroomId, $typeId) {
            if (!is_string($t->desc)) {
                // Not a session-based transaction; include only if no explicit classroom/type filter
                return empty($classroomId) && empty($typeId);
            }
            if (preg_match('/Class session #(\d+)/i', $t->desc, $m)) {
                $sid = (int) $m[1];
                // Include only if session belongs to current org (or no org scoping)
                return isset($sessionIdSet[$sid]) || !$currentOrg;
            }
            // No detectable session link; include it
            return empty($classroomId) && empty($typeId);
        })->values();

        // Group by student + parent
        $grouped = $filtered->groupBy(function ($t) {
            return ($t->student_id ?? '0') . '-' . ($t->parent_id ?? '0');
        });

        $studentIds = $grouped->map(function ($g) {
            return optional($g->first())->student_id;
        })->filter()->unique()->values()->all();
        $parentIds = $grouped->map(function ($g) {
            return optional($g->first())->parent_id;
        })->filter()->unique()->values()->all();

        $students = Student::whereIn('user_id', $studentIds)->get()->keyBy('user_id');
        $parents = Parentt::whereIn('user_id', $parentIds)->get()->keyBy('user_id');

        $rows = $grouped->map(function ($items, $key) use ($students, $parents) {
            $studentId = optional($items->first())->student_id;
            $parentId = optional($items->first())->parent_id;
            $charges = $items->where('is_credit', 0)->sum('price');
            $credits = $items->where('is_credit', 1)->sum('price');
            return [
                'student' => $students->get($studentId),
                'parent' => $parents->get($parentId),
                'student_id' => $studentId,
                'parent_id' => $parentId,
                'transactions_count' => $items->count(),
                'charges' => $charges,
                'credits' => $credits,
                'net' => $charges - $credits,
            ];
        })->sortByDesc('net')->values();

        // Dropdown data for filters
        $classrooms = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $types = ClassSessionType::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->orderBy('name')->get();
        $studentUserIds = Classroom::when($currentOrg, function ($q) use ($currentOrg) {
                $q->where('organization_id', $currentOrg->id);
            })->with('students')->get()->flatMap(function ($c) {
                return $c->students->pluck('id');
            })->unique()->values();
        $studentsList = Student::whereIn('user_id', $studentUserIds)->orderBy('first_name')->get();
        $parentIds = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->distinct()->pluck('parent_id')->filter();
        $parentsList = Parentt::whereIn('user_id', $parentIds)->orderBy('first_name')->get();

        return view('datasource::management.classrooms.report.student_dues', compact(
            'currentOrg',
            'month',
            'studentId',
            'parentId',
            'classroomId',
            'typeId',
            'rows',
            'classrooms',
            'types',
            'studentsList',
            'parentsList'
        ));
    }

    /**
     * Expected Earnings report — projects revenue, instructor payouts, and
     * profit from the classroom schedule (repeats_per_week / days_of_week)
     * so it works even for months with no sessions created yet.
     */
    public function expectedEarnings(Request $request)
    {
        $currentOrg   = $request->attributes->get('currentOrganization');
        $month        = $request->input('month', Carbon::now()->format('Y-m'));
        $instructorId = $request->input('instructor_id');
        $classroomId  = $request->input('classroom_id');
        $typeId       = $request->input('class_session_type_id');
        $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endOfMonth   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

        // ── Fetch classrooms with schedule data ──
        $classrooms = Classroom::with(['defaultSessionType', 'instructor', 'students'])
            ->whereNotNull('instructor_id')
            ->whereNotNull('class_session_type_id')
            ->when($currentOrg, fn ($q) => $q->where('organization_id', $currentOrg->id))
            ->when(!empty($instructorId), fn ($q) => $q->where('instructor_id', $instructorId))
            ->when(!empty($classroomId), fn ($q) => $q->where('id', $classroomId))
            ->when(!empty($typeId), fn ($q) => $q->where('class_session_type_id', $typeId))
            ->orderBy('name')
            ->get();

        // ── Build projection per classroom ──
        $rows = $classrooms->map(function ($classroom) use ($startOfMonth, $endOfMonth) {
            $sessionType        = $classroom->defaultSessionType;
            $pricePerSession    = (float) (optional($sessionType)->price ?? 0);
            $payoutPerSession   = (float) (optional($sessionType)->teacher_payout ?? 0);
            $enrolledStudents   = $classroom->students->count();
            $projectedSessions  = $this->countProjectedSessions($classroom, $startOfMonth, $endOfMonth);

            $expectedRevenue = $pricePerSession * $enrolledStudents * $projectedSessions;
            $expectedPayout  = $payoutPerSession * $enrolledStudents * $projectedSessions;

            return [
                'classroom'          => $classroom,
                'instructor'         => $classroom->instructor,
                'session_type'       => $sessionType,
                'enrolled_students'  => $enrolledStudents,
                'sessions_count'     => $projectedSessions,
                'price_per_session'  => $pricePerSession,
                'payout_per_session' => $payoutPerSession,
                'expected_revenue'   => $expectedRevenue,
                'expected_payout'    => $expectedPayout,
                'expected_profit'    => $expectedRevenue - $expectedPayout,
            ];
        })->values();

        // ── Totals ──
        $totalSessions = $rows->sum('sessions_count');
        $totalRevenue  = $rows->sum('expected_revenue');
        $totalPayout   = $rows->sum('expected_payout');
        $totalProfit   = $rows->sum('expected_profit');

        // ── Per-student breakdown (how much comes from each student) ──
        // Preload every enrolled student's record in one query so the loop below
        // doesn't run a Student query per student per classroom (N+1).
        $studentsById = Student::whereIn(
            'user_id',
            $classrooms->flatMap(fn ($c) => $c->students->pluck('id'))->unique()->values()
        )->get()->keyBy('user_id');

        $studentRows = collect();
        foreach ($classrooms as $classroom) {
            $sessionType       = $classroom->defaultSessionType;
            $pricePerSession   = (float) (optional($sessionType)->price ?? 0);
            $projectedSessions = $this->countProjectedSessions($classroom, $startOfMonth, $endOfMonth);
            $perStudentTotal   = $pricePerSession * $projectedSessions;

            foreach ($classroom->students as $studentUser) {
                $student = $studentsById->get($studentUser->id);
                $key = $studentUser->id;

                if ($studentRows->has($key)) {
                    $existing = $studentRows->get($key);
                    $existing['expected_amount'] += $perStudentTotal;
                    $existing['classrooms_count'] += 1;
                    $studentRows->put($key, $existing);
                } else {
                    $studentRows->put($key, [
                        'student'          => $student,
                        'student_user'     => $studentUser,
                        'expected_amount'  => $perStudentTotal,
                        'classrooms_count' => 1,
                    ]);
                }
            }
        }
        $studentRows = $studentRows->sortByDesc('expected_amount')->values();

        // ── Dropdown data ──
        $instructorIds = Classroom::when($currentOrg, fn ($q) => $q->where('organization_id', $currentOrg->id))
            ->whereNotNull('instructor_id')
            ->distinct()
            ->pluck('instructor_id')
            ->filter()
            ->values();
        $instructors = User::whereIn('id', $instructorIds)->orderBy('first_name')->get();

        $classroomsForFilter = Classroom::when($currentOrg, fn ($q) => $q->where('organization_id', $currentOrg->id))
            ->orderBy('name')
            ->get();

        $types = ClassSessionType::when($currentOrg, fn ($q) => $q->where('organization_id', $currentOrg->id))
            ->orderBy('name')
            ->get();

        return view('datasource::management.classrooms.report.expected_earnings', compact(
            'currentOrg',
            'month',
            'instructorId',
            'classroomId',
            'typeId',
            'rows',
            'studentRows',
            'totalSessions',
            'totalRevenue',
            'totalPayout',
            'totalProfit',
            'instructors',
            'classroomsForFilter',
            'types'
        ));
    }

    /**
     * Map of [session_id => number of students billed] for the month, derived
     * from charge transactions whose description references "Class session #<id>".
     */
    private function billedStudentCountBySession(Carbon $startOfMonth, Carbon $endOfMonth)
    {
        return Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('is_credit', 0)
            ->get()
            ->filter(function ($t) {
                return is_string($t->desc) && preg_match('/Class session #(\d+)/i', $t->desc);
            })
            ->groupBy(function ($t) {
                preg_match('/Class session #(\d+)/i', $t->desc, $m);
                return (int) $m[1];
            })
            ->map(function ($group) {
                return $group->count();
            });
    }

    /**
     * Count how many sessions are projected for a classroom in the given month,
     * based on its days_of_week and repeats_per_week configuration.
     */
    private function countProjectedSessions(Classroom $classroom, Carbon $startOfMonth, Carbon $endOfMonth): int
    {
        $perWeek = (int) $classroom->repeats_per_week;
        if ($perWeek <= 0) {
            return 0;
        }

        $daysCsv = (string) $classroom->days_of_week;
        $days    = array_values(array_filter(
            array_map('intval', explode(',', $daysCsv)),
            fn ($v) => $v >= 1 && $v <= 7
        ));

        // If specific weekdays are configured, count how many fall in the month
        if (!empty($days)) {
            $count  = 0;
            $cursor = $startOfMonth->copy();
            while ($cursor->lte($endOfMonth)) {
                if (in_array($cursor->dayOfWeekIso, $days, true)) {
                    $count++;
                }
                $cursor->addDay();
            }
            return $count;
        }

        // Fallback: repeats_per_week × full weeks in month
        $weeksInMonth = $startOfMonth->diffInWeeks($endOfMonth->copy()->addDay());
        return $perWeek * max(1, (int) $weeksInMonth);
    }
}
