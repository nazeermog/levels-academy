<?php

namespace Modules\LearningPath\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Repositories\DB\CoursePath\Admin\AdminCoursePathRepository;

class LearningPathController extends Controller
{
  public function index()
  {
    $taxonomies = AdminTaxonomyRepository::list();
    $coursePaths = AdminCoursePathRepository::list();
    $coursesCounts = AdminCoursePathRepository::CourseCounter();
    return view('learningpath::student.index', [
      'taxonomies' => $taxonomies,
      'coursePaths' => $coursePaths,
      'coursesCounts' => $coursesCounts,
    ]);
  }
}
