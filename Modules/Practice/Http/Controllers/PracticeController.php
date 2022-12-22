<?php

namespace Modules\Practice\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Practice\Entities\Practice;
use Modules\Question\Entities\Answer;
use Modules\Question\Entities\Question;

class PracticeController extends Controller
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
        return view('practice::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        $practice = new Practice();
        $practice->course_id = 1;
        $practice->title = 'test';
        $practice->save();
        $points = $request->input('points');
        $questions = $request->input('questions');
        $types = $request->input('question_types');
        $answers = $request->input('answers');
        for ($i = 0; $i < count($points); $i++) {

            $question = new Question();
            $question->point = $points[$i];
            $question->question_text = $questions[$i];
            $question->practice_id = $practice->id;

            $question->question_type = $types[$i];
            $question->save();
            $answer = new Answer();
            $answer->is_correct = true;
            $answer->answer = isset($answers[$i]) ? $answers[$i] : $answers[$i + 1];
            $answer->question_id = $question->id;
            $answer->save();


        }
        DB::commit();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('practice::show');
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
