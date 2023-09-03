<?php

namespace DataSource\Http\Requests\Admin\Inrollment;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       $mergeArray = [];
       return array_merge([
        'course_id' => ['numeric','required'],
        'student_id' => ['numeric','required'],
        'approved_at'=>['nullable', 'date'],
    ], $mergeArray);
        return[];
    }
}

