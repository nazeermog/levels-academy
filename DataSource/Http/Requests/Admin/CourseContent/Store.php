<?php

namespace DataSource\Http\Requests\Admin\CourseContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DataSource\Entities\Course\Course;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'ordering' => ['numeric', 'required'],
            'type_id' => ['numeric', 'required'],
            'type' => ['in:Quiz,Practice,Lesson'],
            'course_id' => ['numeric', Rule::in(array_values(Course::services()->active()->pluck('id')->toArray()))],
//            'service_delivery_time' => ['required', 'numeric', Rule::in(array_values(auth()->user()->colors_times_ids))],
        ];
    }
}

