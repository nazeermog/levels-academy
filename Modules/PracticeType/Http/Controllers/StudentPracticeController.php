<?php

namespace Modules\PracticeType\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserEventLogger;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use DataSource\Entities\Course\Course;
use DataSource\Entities\Student\Student;
use DataSource\Entities\Exercise\Exercise;
use DataSource\Entities\Question\Question;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\Support\Renderable;
use DataSource\Entities\Course\CourseStudent;
use Modules\PracticeType\Http\Requests\Store;
use DataSource\Entities\Inrollment\Inrollment;
use DataSource\Entities\PracticeType\PracticeType;
use DataSource\Entities\StudentScore\StudentScore;
use DataSource\Entities\ResultPractice\ResultPractice;
use DataSource\Entities\PracticeType\PracticeTypeDetail;
use DataSource\Repositories\DB\Exercise\Admin\AdminExerciseRepository;
use DataSource\Repositories\DB\Course\Student\StudentCoursesRepository;
use DataSource\Repositories\DB\Exercise\Student\StudentExerciseRepository;
use DataSource\Repositories\DB\Practice\Student\StudentPracticeRepository;
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
    $practices = StudentPracticeRepository::list();

    return view('practicetype::student.index', compact('practices'));
  }

  public function SearchAllExercises()
  {
    $practices = AdminExerciseRepository::list();

    return view('practicetype::student.exercise.bookExercise', compact('practices'));
  }
  public function showAllExercises()
  {
    $practices = AdminExerciseRepository::list();

    // Organize classes based on the starting letter of book_id
    $availableClasses = [];

    foreach ($practices as $practice) {
      $firstLetter = strtolower(substr($practice->book_id, 0, 1));

      // Check if the letter is not already in the array
      if (!in_array($firstLetter, $availableClasses)) {
        $availableClasses[] = $firstLetter;
      }
    }
    // Ensure uniqueness of classes
    $availableClasses = array_unique($availableClasses);
    // dd($availableClasses);
    return view('practicetype::student.exercise.indexBookExercise', compact('availableClasses'));
  }
public function showAllExercisesBYQR($page)
{
    $bookId = request('book_id');
    $query = Exercise::where('page', $page)
        ->orderBy('row')
        ->orderBy('col_count');
    if ($bookId) {
        $query->where('book_id', $bookId);
    }
    $exercises = $query->get();

    if ($exercises->isEmpty()) {
        return view('practicetype::student.exercise.BookExerciseQR', [
            'grouped' => collect(),
            'page' => $page
        ]);
    }

    $grouped = $exercises->groupBy('row');

    return view('practicetype::student.exercise.BookExerciseQR', compact('grouped', 'page'));
}


  public function showAllExercisesBYQR_pages()
  {
    $exercises = Exercise::all()->groupBy('page');

    $pages = $exercises->keys()->sort()->values();

    $pagesWithQrCodes = [];
    foreach ($pages as $page) {
      $pageUrl = url('/student/practice/allBookExercise_qr/' . $page);
      $qrCode = QrCode::size(100)->generate($pageUrl);
      $pagesWithQrCodes[] = [
        'page' => $page,
        'qrCode' => $qrCode,
      ];
    }
    return view('practicetype::student.exercise.BookExerciseBypages_QR', compact('pagesWithQrCodes'));
  }

  public function showAllExercisesBYQR_pagesByBook($book)
  {
    $pages = Exercise::where('book_id', $book)
      ->pluck('page')
      ->unique()
      ->sort()
      ->values();

    $pagesWithQrCodes = [];
    foreach ($pages as $page) {
      $pageUrl = url('/student/practice/allBookExercise_qr/' . $page) . '?book_id=' . urlencode($book);
      $qrCode = QrCode::size(100)->generate($pageUrl);
      $pagesWithQrCodes[] = [
        'page' => $page,
        'qrCode' => $qrCode,
        'book' => $book,
      ];
    }
    return view('practicetype::student.exercise.BookExerciseBypagesForBook_QR', compact('pagesWithQrCodes', 'book'));
  }

  public function showAllExercisesBYQR_books()
  {
    $books = Exercise::query()
      ->select('book_id')
      ->whereNotNull('book_id')
      ->where('book_id', '!=', '')
      ->distinct()
      ->orderBy('book_id')
      ->pluck('book_id');

    return view('practicetype::student.exercise.BookExerciseByBooks_QR', compact('books'));
  }


  public function AllExercisesByClass($class)
  {
    $exercises = Exercise::whereRaw('SUBSTRING(book_id, 1, 1) = ?', [$class])
      ->get();
    foreach ($exercises as $exercise) {
      $exerciseUrl = url('/student/practice/exercise/' . $exercise->book_id . '/types/abacus');
      $exercise->qrCode = QrCode::size(100)->generate($exerciseUrl);
    }
    return view('practicetype::student.exercise.BookExerciseByClass', compact('exercises'));
  }


  public function checkExercise($exerciseCode)
  {
    $exercise = StudentExerciseRepository::findByCode($exerciseCode);

    return response()->json(['exists' => $exercise !== null]);
  }

  public function showExercise($code, $type)
  {
    $timer = 0;
    $seconds_speed = 0;
    $card_number = 0;
    $colCount = 0;
    $results = 0;
    $exercise = StudentExerciseRepository::findByCode($code);
    if ($type == 'numbers_sum') {
      $card_number = $exercise->card_number;
      $seconds_speed = $exercise->seconds_speed;
      $min = $exercise->range_number_from;
      $max =  $exercise->range_number_to;
      $randomNumbers = [
        rand($min, $max),
        rand($min, $max),
        rand($min, $max),
      ];
    } elseif ($type == 'abacus') {
      // dd($exercise);
      $numbers = $exercise->numbers;
      $arrayOfNumbers = explode(',', $numbers);
      $arrayOfNumbers = array_map('trim', $arrayOfNumbers);

      $randomNumbers = [];
      $sum = 0;
      $colCount = $exercise->col_count;
      $results = [];

      foreach ($arrayOfNumbers as $number) {
        $number = (int) $number;

        $randomNumbers[] = $number;

        $sum += $number;

        $result = solveAbacus($sum, $colCount);

        $results[] = $result;
      }
    } elseif ($type == 'math_games' || $type == 'math_games2') {
      $min = $exercise->range_number_from;
      $max =  $exercise->range_number_to;
      $seconds_speed = $exercise->seconds_speed;
      $timer = $exercise->timer;
      $count = $exercise->numbers_to_sum;
      $turns = $exercise->turns;
      $randomNumbers = [];
      for ($i = 0; $i < $turns; $i++) {
        $innerArray = [];

        for ($j = 0; $j < $count; $j++) {
          $innerArray[] = rand($min, $max);
        }
        $randomNumbers[] = $innerArray;
      }
    }

    return view('practicetype::student.exercise.' . $type . 'Exercise', compact('exercise', 'randomNumbers', 'results', 'colCount', 'timer', 'seconds_speed', 'card_number'));
  }
  public function practiceForCourse($id, $type, $courseId)
  {
    $timer = 0;
    $seconds_speed = 0;
    $card_number = 0;
    $colCount = 0;
    $results = 0;
    $practice = StudentPracticeTypeRepository::find($id);
    $course = Course::find($courseId);
    if ($type == 'numbers_sum') {
      $card_number = $practice->card_number;
      $seconds_speed = $practice->seconds_speed;
      $min = $practice->range_number_from;
      $max =  $practice->range_number_to;
      $randomNumbers = [
        rand($min, $max),
        rand($min, $max),
        rand($min, $max),
      ];
    } elseif ($type == 'abacus') {
      $count = $practice->numbers_to_sum;
      $min = $practice->range_number_from;
      $max =  $practice->range_number_to;
      $randomNumbers = [];
      $sum = 0;
      $tables = [];
      $results = [];
      $colCount = $practice->col_count;
      for ($i = 0; $i < $count; $i++) {
        $rand = rand($min, $max);
        $randomNumbers[] = $rand;
        $sum += $rand;
        $result = solveAbacus($sum, $colCount);
        $results[] = $result;
      }
    } elseif ($type == 'math_games' || $type == 'math_games2') {
      $min = $practice->range_number_from;
      $max =  $practice->range_number_to;
      $seconds_speed = $practice->seconds_speed;
      $timer = $practice->timer;
      $count = $practice->numbers_to_sum;
      $turns = $practice->turns;
      $randomNumbers = [];
      for ($i = 0; $i < $turns; $i++) {
        $innerArray = [];

        for ($j = 0; $j < $count; $j++) {
          $innerArray[] = rand($min, $max);
        }
        $randomNumbers[] = $innerArray;
      }
    }
    return view(
      'practicetype::student.forcourse.' . $type . 'ForCourse',
      compact('practice', 'randomNumbers', 'results', 'colCount', 'timer', 'seconds_speed', 'card_number', 'course')
    );
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
  public function store(Request $request) {}

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

  public function showResultPractice()
  {

    return view('practicetype::student.practice_result');
  }

  public function showPractice($id, $type)
  {
    $timer = 0;
    $seconds_speed = 0;
    $card_number = 0;
    $colCount = 0;
    $results = 0;
    $practice = StudentPracticeTypeRepository::find($id);
    if ($type == 'numbers_sum') {
      $card_number = $practice->card_number;
      $seconds_speed = $practice->seconds_speed;
      $min = $practice->range_number_from;
      $max =  $practice->range_number_to;
      $randomNumbers = [
        rand($min, $max),
        rand($min, $max),
        rand($min, $max),
      ];
    } elseif ($type == 'abacus') {
      $count = $practice->numbers_to_sum;
      $min = $practice->range_number_from;
      $max =  $practice->range_number_to;
      $randomNumbers = [];
      $sum = 0;
      $tables = [];
      $results = [];
      $colCount = $practice->col_count;
      for ($i = 0; $i < $count; $i++) {
        $rand = rand($min, $max);
        $randomNumbers[] = $rand;
        $sum += $rand;
        $result = solveAbacus($sum, $colCount);
        $results[] = $result;
      }
    } elseif ($type == 'math_games' || $type == 'math_games2') {
      $min = $practice->range_number_from;
      $max =  $practice->range_number_to;
      $seconds_speed = $practice->seconds_speed;
      $timer = $practice->timer;
      $count = $practice->numbers_to_sum;
      $turns = $practice->turns;
      $randomNumbers = [];
      for ($i = 0; $i < $turns; $i++) {
        $innerArray = [];

        for ($j = 0; $j < $count; $j++) {
          $innerArray[] = rand($min, $max);
        }
        $randomNumbers[] = $innerArray;
      }
    }

    return view('practicetype::student.' . $type, compact('practice', 'randomNumbers', 'results', 'colCount', 'timer', 'seconds_speed', 'card_number'));
  }
  public function showPracticeLevels($id)
  {
    $practice = StudentPracticeRepository::find($id);
    $practiceDetail = PracticeTypeDetail::where('practice_id', $practice->id)->with('practiceLevel')->get();
    return view('practicetype::student.practice_levels', compact('practiceDetail', 'practice'));
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

  public function donePracitce($practiceId, $courseId)
  {
    $practiceId = (int)$practiceId;
    $courseId = (int)$courseId;
    $studentId = auth()->user()->id;
    $inrollment = Inrollment::where('student_id', $studentId)
      ->where('course_id', $courseId)
      ->first();

    if (!$inrollment) {
      return redirect()->back()->withErrors('you should be enroll to this course');
    }
    $semesterId = $inrollment->semester_id;
    $coinsShouldTaken = 0;

    $practice = PracticeTypeDetail::find($practiceId);
    $coinsShouldTaken = $practice->coins_taken;

    StudentScore::create(
      [
        'student_id' => $studentId,
        'practice_id' => $practiceId,
        'course_id' => $courseId,
        'semester_id' => $semesterId,
        'type' => 'course_exercise',
        'coin' => $coinsShouldTaken,
      ]
    );
    $existingRecord = CourseStudent::where('student_id', $studentId)
      ->where('practice_id', $practiceId)
      ->where('course_id', $courseId)
      ->first();
    if (!$existingRecord) {
      CourseStudent::create([
        'student_id' => $studentId,
        'practice_id' => $practiceId,
        'course_id' => $courseId,
      ]);
    }


    $totalPractice = CourseStudent::where('student_id', $studentId)
      ->where('course_id', $courseId)
      ->where('practice_id', $practiceId)
      ->count();

    $course = Course::find($courseId);
    $TotalPracticeOld = StudentPracticeRepository::SingleCoursTotalPractice($course);
    $progressPercentage = ($totalPractice / $TotalPracticeOld) * 100;
    if ($inrollment) {
      $inrollment->progress_practice = number_format($progressPercentage, 1);
      $inrollment->update();
    }
    UserEventLogger::log('practice solved','practice solved ' . $practice->title . ' and ' . $coinsShouldTaken . ' coins added','pracitce_done');
    return redirect()->back()->withSuccess('practice marked as done');
  }
  public function donePracitceForOutsideCourse($practiceId)
  {
    $practiceId = (int)$practiceId;

    $studentId = auth()->user()->id;
    $coinsShouldTaken = 0;

    $practice = PracticeTypeDetail::find($practiceId);
    $coinsShouldTaken = $practice->coins_taken;
    StudentScore::create(
      [
        'student_id' => $studentId,
        'practice_id' => $practiceId,
        'course_id' => 0,
        'semester_id' => 0,
        'type' => 'exercise',
        'coin' => $coinsShouldTaken,
      ]
    );
    UserEventLogger::log('practice solved','practice solved ' . $practice->title . ' and ' . $coinsShouldTaken . ' coins added','pracitce_done');

    return redirect()->back()->withSuccess('practice marked as done and coin added');
  }
  public function donePracitceForBookExerise($practiceId)
  {
    $practiceId = (int)$practiceId;

    $studentId = auth()->user()->id;
    $coinsShouldTaken = 0;

    $practice = PracticeTypeDetail::find($practiceId);
    $coinsShouldTaken = $practice->coins_taken;

    StudentScore::create(
      [
        'student_id' => $studentId,
        'practice_id' => $practiceId,
        'course_id' => 0,
        'semester_id' => 0,
        'type' => 'book_exercise',
        'coin' => $coinsShouldTaken,
      ]
    );
    UserEventLogger::log('practice solved','practice solved ' . $practice->title . ' and ' . $coinsShouldTaken . ' coins added','pracitce_done');
    return redirect()->back()->withSuccess('practice marked as done and coin added');
  }
}

function getExactLength($number, $colCount)
{
  $prefix = "";
  for ($i = 0; $i < ($colCount - strlen(strval($number))); $i++) {
    $prefix .= "0";
  }
  return $prefix . $number;
}
function getDigitsAsNumbers($number)
{
  $digitsAsString = (string) $number;
  $digits = str_split($digitsAsString);
  return $digits;
}
function giveOnecol($number)
{
  $number = (int)$number;
  $five = (int)(floor($number / 5));
  $number %= 5;
  $four = $number >= 4 ? 1 : 0;
  $three = $number >= 3 ? 1 : 0;
  $two = $number >= 2 ? 1 : 0;
  $one = $number >= 1 ? 1 : 0;
  return [$four, $three, $two, $one, $five];
}
function solveAbacus($number, $colCount)
{
  $matrix = [];
  $number = getExactLength($number, $colCount);
  $number = strrev($number);
  $result = getDigitsAsNumbers($number);
  $i = 0;
  foreach ($result as $element) {
    $matrix[$i] = giveOnecol($element);
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
  $html = "<table border='1' style='margin=10;'>";
  foreach ($data as $row) {
    $html .= "<tr>";
    foreach ($row as $cell) {
      $html .= "<td>" . $cell . "</td>";
    }
    $html .= "</tr>";
  }
  $html .= "</table>";
  return html_entity_decode($html);
}
