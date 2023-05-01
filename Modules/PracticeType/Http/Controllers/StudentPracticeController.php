<?php

namespace Modules\PracticeType\Http\Controllers;

use DataSource\Repositories\DB\Practice\Student\StudentPracticeTypeRepository;
use DataSource\Repositories\DB\ResultPractice\Student\StudentResultPracticeRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Practice\Http\Requests\Store;


class StudentPracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('practice::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return view('practice::student.take_quiz');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $questions = Question::where('practice_id', $id)->get();
        return view('practice::student.take_quiz', compact('questions'));
    }

    public function showPractice($id)
    {
        $practice = StudentPracticeTypeRepository::find($id);
        return view('practice::student.numbers_sum', compact('practice'));
    }

    public function sendResultPractice(Store $request)
    {
        try {
            DB::beginTransaction();
            $data = StudentResultPracticeRepository::sendResult($request->validated());
            DB::commit();
            return response()->json([
                'data' => $data,
                'status' => true,
                'message' => 'result Sent',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('practice::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
