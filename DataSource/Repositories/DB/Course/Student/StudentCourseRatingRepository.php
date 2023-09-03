<?php

namespace DataSource\Repositories\DB\Course\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use DataSource\Entities\Course\Rating;
use DataSource\Entities\Instructor\Instructor;

class StudentCourseRatingRepository
{
  public static function ratingWithComments($course)
  {
    // $ratings=Rating::where('course_id', $course->id)->get();
    // $ratingWithComments=[];

    // foreach($ratings as $rating){
    //   if($rating->user_review!=null){
    //     $ratingWithComments[]=$rating;
    //   }
    // }
    $perPage = 4;
    $ratingWithCommentsPaginated = DB::table('ratings')
      ->where('course_id', $course->id)
      ->whereNotNull('user_review')
      ->paginate($perPage);
    return $ratingWithCommentsPaginated;
  }

  public static function RatingCount($course)
  {
    $ratingsCount = Rating::where('course_id', $course->id)->count();
    return $ratingsCount;
  }

  public static function CountEachStar5($course)
  {
    $ratingsCount = Rating::where('course_id', $course->id)->count();
    if ($ratingsCount === 0) {
      return 0;
    }

    $rating5 = Rating::where('course_id', $course->id)->where('rate', 5)->count();

    $finalRate = $rating5 / $ratingsCount * 100;
    return $finalRate;
  }

  public static function CountEachStar4($course)
  {
    $ratingsCount = Rating::where('course_id', $course->id)->count();
    if ($ratingsCount === 0) {
      return 0;
    }
    $rating5 = Rating::where('course_id', $course->id)->where('rate', 4)->count();

    $finalRate = $rating5 / $ratingsCount * 100;
    return $finalRate;
  }
  public static function CountEachStar3($course)
  {
    $ratingsCount = Rating::where('course_id', $course->id)->count();
    if ($ratingsCount === 0) {
      return 0;
    }
    $rating5 = Rating::where('course_id', $course->id)->where('rate', 3)->count();

    $finalRate = $rating5 / $ratingsCount * 100;
    return $finalRate;
  }
  public static function CountEachStar2($course)
  {
    $ratingsCount = Rating::where('course_id', $course->id)->count();
    if ($ratingsCount === 0) {
      return 0;
    }
    $rating5 = Rating::where('course_id', $course->id)->where('rate', 2)->count();

    $finalRate = $rating5 / $ratingsCount * 100;
    return $finalRate;
  }
  public static function CountEachStar1($course)
  {
    $ratingsCount = Rating::where('course_id', $course->id)->count();
    if ($ratingsCount === 0) {
      return 0;
    }
    $rating5 = Rating::where('course_id', $course->id)->where('rate', 1)->count();

    $finalRate = $rating5 / $ratingsCount * 100;
    return $finalRate;
  }


  public static function CalculateAverageRatingForCourse($course)
  {
    $ratings = Rating::where('course_id', $course->id)->pluck('rate')->toArray();
    $totalRatings = count($ratings);

    if ($totalRatings === 0) {
      return 0;
    }

    $sumRatings = array_sum($ratings);
    $averageRating = $sumRatings / $totalRatings;

    return $averageRating;
  }

  public static function CalculateAverageRatingForAllCourses($courses)
  {
    $averageRatings = [];

    foreach ($courses as $course) {
      $totalRatings = $course->ratings()->get();
      $ratingsCount = $totalRatings->count();
      if ($ratingsCount == 0) {
        $averageRatings[$course->id] = 0;
      } else {
        $sumRatings = $totalRatings->sum('rate');
        $averageRating = $sumRatings / $ratingsCount;
        $averageRatings[$course->id] = $averageRating;
      }
    }

    return $averageRatings;
  }
  public static function ratingOnce($course)
  {
    $canRate = true;
    $authStudentId = auth()->user()->id;

    $rating = Rating::where('user_id', $authStudentId)->where('course_id', $course->id)->first();
    if ($rating) {
      $canRate = false;
    }
    return $canRate;
  }
}
