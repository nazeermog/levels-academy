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
            'arrayData' => ['array', 'required'],
            'arrayData.*.ordering' => ['numeric', 'required'],
            'arrayData.*.type_id' => ['numeric', 'required'],
            'arrayData.*.type' => ['in:Quiz,Practice,Lesson'],
            'course_id' => ['numeric', 'exists:courses,id'],
        ];
    }
}

