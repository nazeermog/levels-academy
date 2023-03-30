<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Modules\DataResource\Repositories\DB\Course\Student\StudentCoursesRepository;

class StudentCoursesController extends Controller
{
    private $repository;

    public function __construct()
    {
        if (is_null($this->repository))
            $this->repository = new StudentCoursesRepository();
        return $this->repository;
    }

    public function list($categoryId)
    {
        $response = $this->repository->getCourses($categoryId);
        return response()->json($response['data'], $response['code']);
    }
}
