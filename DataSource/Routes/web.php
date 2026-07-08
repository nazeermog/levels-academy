<?php

use Illuminate\Support\Facades\Route;
use DataSource\Http\Controllers\Admin\Blog\AdminBlogController;
use DataSource\Http\Controllers\Admin\Order\AdminOrderController;
use DataSource\Http\Controllers\Admin\Lesson\AdminLessonController;
use DataSource\Http\Controllers\Admin\Parentt\AdminParenttController;
use DataSource\Http\Controllers\Admin\Product\AdminProductController;
use DataSource\Http\Controllers\Admin\Student\AdminStudentController;
use DataSource\Http\Controllers\Admin\Exercise\AdminExerciseController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeController;
use DataSource\Http\Controllers\Admin\Semester\AdminSemesterController;
use DataSource\Http\Controllers\Admin\Taxonomy\AdminTaxonomyController;
use DataSource\Http\Controllers\Admin\Dashboard\AdminDashboardController;
use DataSource\Http\Controllers\Admin\CoursePath\AdminCoursePathController;
use DataSource\Http\Controllers\Admin\Inrollment\AdminInrollmentController;
use DataSource\Http\Controllers\Admin\Instructor\AdminInstructorController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeTypeController;
use DataSource\Http\Controllers\Admin\Practice\AdminPracticeLevelController;
use DataSource\Http\Controllers\Admin\CourseContent\AdminCourseContentController;
use DataSource\Http\Controllers\Admin\Course\AdminCourseProgressController;
use DataSource\Http\Controllers\Admin\ResultPractice\AdminResultPracticeController;
use DataSource\Http\Controllers\Admin\CategoryProduct\AdminCategoryProductController;
use DataSource\Http\Controllers\Admin\Instructor\AdminInstructorNoteController;
use DataSource\Http\Controllers\Admin\Organization\OrgAdminDashboardController;
use DataSource\Http\Controllers\Admin\Classroom\AdminClassroomController;
use DataSource\Http\Controllers\Admin\Classroom\AdminClassSessionTypeController;
use DataSource\Http\Controllers\Admin\Classroom\AdminClassroomReportController;
use DataSource\Http\Controllers\Admin\Organization\AdminOrganizationUsersController;
use DataSource\Http\Controllers\Admin\Organization\OrganizationController;
use DataSource\Http\Controllers\Admin\Absence\AdminAbsenceController;
use DataSource\Http\Controllers\Admin\Organization\OrgSettingsController;
use DataSource\Http\Controllers\Admin\FreeSession\AdminFreeSessionController;


// Master switch: when organizations are OFF, admins get the full global catalog
// ("sees everything" mode). When ON, the global catalog is super_admin-only and
// admins are scoped to their organization screens (original behaviour).
$catalogGuard = config('features.organizations') ? 'role:super_admin' : 'role:super_admin,admin';

// Global admin catalog/content management
Route::prefix('admin')->middleware(['auth', $catalogGuard])->group(function () {
    Route::group(['as' => 'admin.'], function () {
        // Org Admin - Users listing for current organization only
        Route::resource('courseContent', AdminCourseContentController::class);
        Route::resource('practices', AdminPracticeController::class);
        Route::resource('practicesType', AdminPracticeTypeController::class);
        Route::resource('Practiceslevels', AdminPracticeLevelController::class);
        Route::resource('taxonomies', AdminTaxonomyController::class);
        Route::resource('coursePath', AdminCoursePathController::class);
        Route::resource('lessons', AdminLessonController::class);
        Route::resource('instructors', AdminInstructorController::class);
        Route::resource('semesters', AdminSemesterController::class);
        Route::resource('students', AdminStudentController::class);
        // Upgrade a trial student (self-registered via API) to a full student.
        Route::post('students/{user}/promote', [AdminStudentController::class, 'promote'])->name('students.promote');
        Route::resource('parentts', AdminParenttController::class);
        Route::resource('exercises', AdminExerciseController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('categoryProducts', AdminCategoryProductController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('blogs', AdminBlogController::class);
        Route::resource('inrollments', AdminInrollmentController::class);

        Route::get('course-progress', [AdminCourseProgressController::class, 'index'])->name('course-progress.index');
        Route::get('course-progress/{course}', [AdminCourseProgressController::class, 'show'])->name('course-progress.show');

        Route::get('resultPractices', [AdminResultPracticeController::class, 'index'])->name('resultPractices.index');
        Route::get('instructor-notes', [AdminInstructorNoteController::class, 'index'])->name('instructor-notes.index');
    });
});

// Organization management (super_admin only). Hidden from the UI for now via
// the `features.organizations` flag, but kept registered so it can be restored.
Route::prefix('admin')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::group(['as' => 'admin.'], function () {
        Route::resource('organizations', OrganizationController::class)->except(['show']);
    });
});

// Free session waiting list + assignment (super_admin + admin)
Route::prefix('admin')->middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::get('free-sessions', [AdminFreeSessionController::class, 'index'])->name('admin.free-sessions.index');
    Route::get('free-sessions/{freeSession}/assign', [AdminFreeSessionController::class, 'assignForm'])->name('admin.free-sessions.assign.form');
    Route::post('free-sessions/{freeSession}/assign', [AdminFreeSessionController::class, 'assign'])->name('admin.free-sessions.assign');
});

Route::prefix('admin')->middleware(['auth', $catalogGuard])->group(function () {
    Route::get('students2/tiles', [AdminStudentController::class, 'tiles'])->name('admin.students2.tiles');

    Route::get('/students/import/form', [AdminStudentController::class, 'importform'])->name('admin.importstudents.form');
    Route::post('/students/import', [AdminStudentController::class, 'import'])->name('admin.students.import');

    Route::get('/students/csv/{filename}', function ($filename) {
        $path = storage_path("app/imports/{$filename}");
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }
        return response()->download($path);
    })->name('admin.download.csv');
});


Route::group([
    'middleware' => ['auth', $catalogGuard]
], function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Organization admin (scoped admin)
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('organization/dashboard', [OrgAdminDashboardController::class, 'index'])->name('admin.org.dashboard');
    Route::get('organization/users', [AdminOrganizationUsersController::class, 'index'])->name('admin.org.users.index');
    Route::get('organization/instructor-notes', [AdminInstructorNoteController::class, 'index'])->name('admin.org.instructor-notes.index');
    Route::resource('organization/classrooms', AdminClassroomController::class)->names([
        'index' => 'admin.org.classrooms.index',
        'create' => 'admin.org.classrooms.create',
        'store' => 'admin.org.classrooms.store',
        'edit' => 'admin.org.classrooms.edit',
        'update' => 'admin.org.classrooms.update',
        'destroy' => 'admin.org.classrooms.destroy',
        'show' => 'admin.org.classrooms.show',
    ]);
    Route::resource('organization/class-session-types', AdminClassSessionTypeController::class)->names([
        'index' => 'admin.org.class_session_types.index',
        'create' => 'admin.org.class_session_types.create',
        'store' => 'admin.org.class_session_types.store',
        'edit' => 'admin.org.class_session_types.edit',
        'update' => 'admin.org.class_session_types.update',
        'destroy' => 'admin.org.class_session_types.destroy',
        'show' => 'admin.org.class_session_types.show',
    ])->parameters(['class-session-types' => 'class_session_type']);

    // Absences
    Route::get('organization/absences', [AdminAbsenceController::class, 'index'])->name('admin.org.absences.index');

    // Org settings (org admin only)
    Route::get('organization/settings', [OrgSettingsController::class, 'edit'])->name('admin.org.settings.edit');
    Route::put('organization/settings', [OrgSettingsController::class, 'update'])->name('admin.org.settings.update');

    Route::prefix('organization/classrooms/reports')->name('admin.org.classrooms.reports.')->group(function () {
        Route::get('instructors', [AdminClassroomReportController::class, 'instructorTotals'])->name('instructors');
        Route::get('profit', [AdminClassroomReportController::class, 'profit'])->name('profit');
        Route::get('student-dues', [AdminClassroomReportController::class, 'studentDues'])->name('student_dues');
        Route::get('expected-earnings', [AdminClassroomReportController::class, 'expectedEarnings'])->name('expected_earnings');
    });
});
