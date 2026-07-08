<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The DB has no foreign keys, so rows can dangle when a parent is deleted
 * (e.g. an enrolment whose course is gone) — these crash views. This command
 * reports them, and deletes them with --force. It never touches `transactions`
 * (money history). Sentinel course_id = 0 rows are left alone.
 */
class CleanupOrphans extends Command
{
    protected $signature = 'data:cleanup-orphans {--force : Actually delete (default is a dry-run report)}';

    protected $description = 'Report (and with --force delete) rows orphaned by a missing parent.';

    public function handle(): int
    {
        $force = (bool) $this->option('force');
        $this->info($force
            ? 'CLEANUP MODE — orphaned rows will be DELETED.'
            : 'DRY RUN — nothing deleted. Re-run with --force to delete.');
        $this->newLine();

        // [table, human description, fn returning a query matching ONLY orphaned rows]
        $targets = [
            ['inrollments', 'enrolments whose course was deleted',
                fn () => DB::table('inrollments')->where('course_id', '>', 0)
                    ->whereNotIn('course_id', DB::table('courses')->select('id'))],
            ['course_contents', 'content boxes whose course was deleted',
                fn () => DB::table('course_contents')->where('course_id', '>', 0)
                    ->whereNotIn('course_id', DB::table('courses')->select('id'))],
            ['course_steps', 'steps whose content box was deleted',
                fn () => DB::table('course_steps')
                    ->whereNotIn('course_content_id', DB::table('course_contents')->select('id'))],
            ['course_students', 'completions whose course was deleted',
                fn () => DB::table('course_students')->where('course_id', '>', 0)
                    ->whereNotIn('course_id', DB::table('courses')->select('id'))],
            ['class_session_student', 'attendance rows whose session was deleted',
                fn () => DB::table('class_session_student')
                    ->whereNotIn('class_session_id', DB::table('class_sessions')->select('id'))],
        ];

        $total = 0;
        foreach ($targets as [$table, $desc, $query]) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            $count = $query()->count();
            $total += $count;
            $this->line(sprintf('  %-24s %5d  %s', $table, $count, "($desc)"));
            if ($force && $count > 0) {
                $deleted = $query()->delete();
                $this->info("      -> deleted {$deleted}");
            }
        }

        $this->newLine();
        $this->info($force
            ? "Done. Removed {$total} orphaned rows."
            : "Found {$total} orphaned rows. Run: php artisan data:cleanup-orphans --force");

        return self::SUCCESS;
    }
}
