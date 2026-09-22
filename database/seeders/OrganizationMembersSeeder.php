<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataSource\Entities\User\User;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Parentt\Parentt;
use DataSource\Entities\Instructor\Instructor;
use DataSource\Entities\Organization\Organization;

class OrganizationMembersSeeder extends Seeder
{
    public function run()
    {
        // This seeder is intentionally scoped to yasmine org.
        $organizations = Organization::query()
            ->where('subdomain', 'yasmine')
            ->get();

        foreach ($organizations as $org) {
            $sub = $org->subdomain;

            // Parents
            $parents = [];
            for ($i = 1; $i <= 3; $i++) {
                $email = "parent{$i}@{$sub}.com";
                $parentUser = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'first_name' => ucfirst($sub),
                        'last_name' => "Parent {$i}",
                        'password' => Hash::make('123456789'),
                        'role' => 'parentt',
                        'organization_id' => $org->id,
                    ]
                );

                $parent = Parentt::updateOrCreate(
                    ['user_id' => $parentUser->id],
                    [
                        'first_name' => ucfirst($sub),
                        'last_name' => "Parent {$i}",
                        'user_id' => $parentUser->id,
                    ]
                );

                $parents[] = $parent;
            }

            // Students
            $students = [];
            for ($i = 1; $i <= 3; $i++) {
                $email = "student{$i}@{$sub}.com";
                $studentUser = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'first_name' => ucfirst($sub),
                        'last_name' => "Student {$i}",
                        'password' => Hash::make('123456789'),
                        'role' => 'student',
                        'organization_id' => $org->id,
                    ]
                );

                $student = Student::updateOrCreate(
                    ['user_id' => $studentUser->id],
                    [
                        'first_name' => ucfirst($sub),
                        'last_name' => "Student {$i}",
                        'user_id' => $studentUser->id,
                        'country' => 'N/A',
                        'city' => 'N/A',
                        'avatar' => '',
                    ]
                );

                $students[] = $student;
            }

            // Link each generated parent to the matching generated student.
            // On the current seeded database this is Parent 8 -> Student 11,
            // Parent 9 -> Student 12, and Parent 10 -> Student 13.
            $parentUserIds = collect($parents)->pluck('user_id')->map(fn($id) => (int) $id)->filter()->values()->all();
            $studentUserIds = collect($students)->pluck('user_id')->map(fn($id) => (int) $id)->filter()->values()->all();

            // Reset links for this org's generated parents/students to keep deterministic mapping.
            DB::table('parentt_student')
                ->whereIn('parentt_id', $parentUserIds)
                ->orWhereIn('student_id', $studentUserIds)
                ->orWhere('parentt_id', 0)
                ->orWhere('student_id', 0)
                ->delete();

            for ($i = 1; $i <= 3; $i++) {
                $parentUserId = User::where('email', "parent{$i}@{$sub}.com")->value('id');
                $studentUserId = User::where('email', "student{$i}@{$sub}.com")->value('id');

                if ($parentUserId && $studentUserId) {
                    DB::table('parentt_student')->insertOrIgnore([
                        'parentt_id' => (int) $parentUserId,
                        'student_id' => (int) $studentUserId,
                    ]);
                }
            }

            // Instructors
            for ($i = 1; $i <= 3; $i++) {
                $email = "instructor{$i}@{$sub}.com";
                $instructorUser = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'first_name' => ucfirst($sub),
                        'last_name' => "Instructor {$i}",
                        'password' => Hash::make('123456789'),
                        'role' => 'instructor',
                        'organization_id' => $org->id,
                    ]
                );

                Instructor::updateOrCreate(
                    ['user_id' => $instructorUser->id],
                    [
                        'user_id' => $instructorUser->id,
                        'first_name' => ucfirst($sub),
                        'last_name' => "Instructor {$i}",
                        'avatar' => null,
                    ]
                );
            }
        }
    }
}
