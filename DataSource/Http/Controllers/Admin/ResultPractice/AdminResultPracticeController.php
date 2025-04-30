<?php

namespace DataSource\Http\Controllers\Admin\ResultPractice;

use Illuminate\Http\Request;
use DataSource\Entities\Student\Student;
use DataSource\Http\Controllers\BaseController;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\PracticeType\PracticeTypeDetail;
use DataSource\Entities\ResultPractice\ResultPractice;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\ResultPractice\Admin\AdminResultPracticeRepository;

class AdminResultPracticeController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.resultPractice';
    protected string $table_name = 'Result Practices';
    protected string $route_name = 'admin.resultPractices';
    protected string $interface = AdminResultPracticeRepository::class;
    //    protected string $interface_category = AdminCategoryRepository::class;
    //    protected string $store_request = Store::class;
    //    protected string $update_request = Update::class;
    //    protected $id_request = Id::class;

    public function index(Request $request)
    {
        $query = ResultPractice::with(['student', 'practice', 'resultsType'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('student', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                })
                    ->orWhere('level_title', 'like', '%' . $request->search . '%');
            })
            ->when($request->student_id, function ($q) use ($request) {
                $q->where('student_id', $request->student_id);
            })
            ->when($request->practice_id, function ($q) use ($request) {
                $q->where('practice_id', $request->practice_id);
            })
            ->when($request->from_date, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->to_date, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to_date);
            })
            ->when(isset($request->is_true), function ($q) use ($request) {
                $q->where('is_true', $request->is_true);
            });

        $totalAttempts = $query->count();
        $correctAnswers = $query->clone()->where('is_true', true)->count();
        $incorrectAnswers = $totalAttempts - $correctAnswers;
        $correctPercentage = $totalAttempts > 0 ? ($correctAnswers / $totalAttempts) * 100 : 0;
        $incorrectPercentage = $totalAttempts > 0 ? ($incorrectAnswers / $totalAttempts) * 100 : 0;

        $list = $query->orderBy('created_at', 'desc')->paginate(20);

        $students = Student::all();
        $practices = PracticeType::all();

        return view($this->module . '.index', [
            'list' => $list,
            'route_name' => $this->route_name,
            'table_name' => $this->table_name,
            'students' => $students,
            'practices' => $practices,
            'totalAttempts' => $totalAttempts,
            'correctAnswers' => $correctAnswers,
            'incorrectAnswers' => $incorrectAnswers,
            'correctPercentage' => $correctPercentage,
            'incorrectPercentage' => $incorrectPercentage,
            'searchParams' => $request->all()
        ]);
    }
}
