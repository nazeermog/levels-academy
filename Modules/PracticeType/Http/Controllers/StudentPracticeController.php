<?php

namespace Modules\PracticeType\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use DataSource\Entities\Question\Question;
use Illuminate\Contracts\Support\Renderable;
use Modules\PracticeType\Http\Requests\Store;
use DataSource\Repositories\DB\Practice\Student\StudentPracticeTypeRepository;
use DataSource\Repositories\DB\ResultPractice\Student\StudentResultPracticeRepository;


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

    return view('practicetype::student.take_quiz');
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
    return view('practicetype::student.take_quiz', compact('questions'));
  }

  public function showPractice($id, $type = 'numbers_sum')
  {

    $practice = StudentPracticeTypeRepository::find($id);
    $min = 50;     // Minimum value
    $max = 100;   // Maximum value

    $randomNumbers = [
      rand($min, $max),
      rand($min, $max),
      rand($min, $max),
    ];

    return view('practicetype::student.' . $type, compact('practice', 'randomNumbers'));
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
  public function solver()
  {
    $count = 4;
    $min = 1;
    $max = 10;
    $randomNumbers = [];
    $sum=0;
    $tables=[];
    $results = [];
    $colCount=4;
    for ($i = 0; $i < $count; $i++) {
      $rand=rand($min, $max);
      //$rand=1;
      $randomNumbers[] = $rand;
      $sum+=$rand;
      $result = solveAbacus($sum,$colCount);
      //$result=rotateArray($result);

      // $table=printTableFromArray($result);
      // $tables[]=$table;
      $results[] = $result;
    }
    return view('practicetype::student.abacus', compact('randomNumbers','results'));
  }
}

Function getExactLength($number,$colCount) {
  $prefix="";
  for ($i = 0; $i < ($colCount-strlen(strval($number))); $i++) {
      $prefix.="0";
  }
  return $prefix.$number;
}
function getDigitsAsNumbers($number)
{
  $digitsAsString = (string) abs($number);
  $digits = array_map('intval', str_split($digitsAsString));
  return $digits;
}
function giveOnecol($number)
{
  $five = (int)(floor($number / 5));
  $number %= 5;
  $four = $number >= 4 ? 1 : 0;
  $three = $number >= 3 ? 1 : 0;
  $two = $number >= 2 ? 1 : 0;
  $one = $number >= 1 ? 1 : 0;
  return [$four, $three, $two, $one, $five];
}
function solveAbacus($number,$colCount){
  $matrix=[];
  $number=getExactLength($number,$colCount);
  $number=strrev($number);
  $result = getDigitsAsNumbers($number);
  $i=0;
  foreach ($result as $element) {
      $matrix[$i]=giveOnecol($element);
      $i++;
  }
  return $matrix;
}
function transposeArray($array)
{
  $transposedArray = array();
  foreach ($array as $rowIndex => $row) {
    foreach ($row as $colIndex => $value) {
      $transposedArray[$colIndex][$rowIndex] = $value;
    }
  }
  return $transposedArray;
}
function printTableFromArray($data)
{
  $html= "<table border='1' style='margin=10;'>";
  foreach ($data as $row) {
    $html.= "<tr>";
    foreach ($row as $cell) {
      $html.= "<td>" . $cell . "</td>";
    }
    $html.= "</tr>";
  }
  $html.= "</table>";
  return html_entity_decode($html);
}


