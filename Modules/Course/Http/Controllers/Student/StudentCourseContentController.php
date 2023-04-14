<?php

namespace Modules\Course\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Modules\DataResource\Repositories\DB\Course\Student\StudentCourseContentRepository;


class StudentCourseContentController extends Controller
{
    private $repository;

    public function __construct()
    {
        if (is_null($this->repository))
            $this->repository = new StudentCourseContentRepository();
        return $this->repository;
    }

    public function getCourseContent($courseId)
    {
        $response = $this->repository->getCourseContent($courseId);
        return response()->json($response['data'], $response['code']);
    }

    public function getContent($contentId)
    {
        $response = $this->repository->getContent($contentId);
        return response()->json($response['data'], $response['code']);
    }
}
