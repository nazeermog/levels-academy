<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DataSource\Entities\Course\CourseStep;
use DataSource\Entities\Course\CourseContent;
use DataSource\Entities\Lesson\Lesson;
use DataSource\Entities\Classroom\ClassSession;
use DataSource\Entities\PracticeType\PracticeTypeDetail;

/**
 * Read-only report of course steps whose stepable_id no longer resolves to a real
 * lesson / practice / class session (the corruption caused by the old edit-save bug).
 * Nothing is changed — the admin should re-add the listed steps in the course builder.
 */
class CheckCourseSteps extends Command
{
    protected $signature = 'course:check-steps';

    protected $description = 'List course steps whose stepable_id points at a missing lesson/practice/session.';

    public function handle(): int
    {
        $lessonIds   = array_flip(Lesson::pluck('id')->all());
        $practiceIds = array_flip(PracticeTypeDetail::pluck('id')->all());
        $sessionIds  = array_flip(ClassSession::pluck('id')->all());

        // content_id => "Course title / Content title" for context
        $contents = CourseContent::with('course')->get()->keyBy('id');

        $bad = [];
        CourseStep::orderBy('course_content_id')->orderBy('ordering')->chunk(300, function ($steps) use ($lessonIds, $practiceIds, $sessionIds, $contents, &$bad) {
            foreach ($steps as $s) {
                $id = (int) $s->stepable_id;
                $ok = match ($s->stepable_type) {
                    'Lessons'       => isset($lessonIds[$id]),
                    'Practices'     => isset($practiceIds[$id]),
                    'ClassSessions' => isset($sessionIds[$id]),
                    default         => true, // Quizzes / unknown types aren't validated
                };
                if (!$ok) {
                    $content = $contents[$s->course_content_id] ?? null;
                    $bad[] = [
                        'step'    => $s->id,
                        'type'    => $s->stepable_type,
                        'bad_id'  => $id,
                        'course'  => optional(optional($content)->course)->title ?? ('course_content #'.$s->course_content_id),
                        'box'     => optional($content)->title,
                    ];
                }
            }
        });

        if (empty($bad)) {
            $this->info('All course steps resolve correctly. No corrupted stepable_id found.');
            return self::SUCCESS;
        }

        $this->warn(count($bad).' step(s) point at a missing target — re-add them in the course builder:');
        $this->table(['Step ID', 'Type', 'Missing ID', 'Course', 'Content box'], array_map(fn ($b) => [
            $b['step'], $b['type'], $b['bad_id'], $b['course'], $b['box'],
        ], $bad));

        return self::SUCCESS;
    }
}
