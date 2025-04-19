<?php

namespace DataSource\Repositories\DB;

use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminInrollmentRepository
{
  use AdminCRUDGenericRepository;

  protected $model = Inrollment::class;
  public function list()
  {
    $list = AdminInrollmentRepository::listWithProgress();

    return $list;
  }
  public static function listWithRelations()
  {
    return Inrollment::with([
      'course',
      'student.user',
      'semester',
    ])->get();
  }

  public static function listWithProgress()
  {
    $enrollments = self::listWithRelations();

    foreach ($enrollments as $enrollment) {
      $enrollment->setAttribute('progress', [
        'practice' => $enrollment->progress_practice ?? 0,
        'lesson'   => $enrollment->progress_lesson ?? 0,
        'quiz'     => $enrollment->progress_quiz ?? 0,
      ]);
    }

    return $enrollments;
  }
}
