<?php

namespace DataSource\Http\Requests\Admin\Parentt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DataSource\Entities\Lesson\Lesson;

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
        'student_id' => ['required'],
        'first_name' => ['required','string'],
        'last_name' => ['required','string'],
        'email' => ['required','email'],
        'password'=>['required'],


    ], $mergeArray);
        return[];
    }
}

