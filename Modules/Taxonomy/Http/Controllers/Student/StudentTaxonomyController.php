<?php

namespace Modules\Taxonomy\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use DataSource\Repositories\DB\Taxonomy\Student\StudentTaxonomyRepository;

class StudentTaxonomyController extends Controller
{
    private $repository;

    public function __construct()
    {
        if (is_null($this->repository))
            $this->repository = new StudentTaxonomyRepository();
        return $this->repository;
    }

    public function list($partnerId)
    {
        $response = $this->repository->getCategories($partnerId);
        return response()->json($response['data'], $response['code']);
    }
}
