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

            // Link parents to students (1-to-1 mapping for sample data)
            $parentUserIds = collect($parents)->pluck('user_id')->map(fn($id) => (int) $id)->all();
            $studentUserIds = collect($students)->pluck('user_id')->map(fn($id) => (int) $id)->all();

            // Reset links for this org's generated parents/students to keep deterministic mapping.
            DB::table('parentt_student')
                ->whereIn('parentt_id', $parentUserIds)
                ->orWhereIn('student_id', $studentUserIds)
                ->delete();

            for ($i = 0; $i < 3; $i++) {
                if (isset($parents[$i]) && isset($students[$i])) {
                    // Parent i -> Student i (user_id based keys)
                    $parentUserId = (int) $parents[$i]->user_id;
                    $studentUserId = (int) $students[$i]->user_id;

                    DB::table('parentt_student')->insert([
                        'parentt_id' => $parentUserId,
                        'student_id' => $studentUserId,
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


