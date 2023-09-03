<?php

namespace Modules\Course\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\Course\Rating;


class StudentCourseRatingController extends Controller
{
  public function rateCourse(Request $request, $courseId)
    {
        $data = $request->validate([
            'rate' => 'required|integer|in:1,2,3,4,5',
            'user_review' => 'nullable|string',
            
        ]);
        $rating = new Rating([
            'course_id' => $courseId,
            'user_id' =>auth()->user()->id,
            'rate' => $data['rate'],
            'user_name' => 'fakeName',
            'user_review' => $data['user_review'] ?? null,
        ]);
        $rating->save();

        return redirect()->back()->withSuccess('success', 'Thank you for rating the course!');
    }

}
