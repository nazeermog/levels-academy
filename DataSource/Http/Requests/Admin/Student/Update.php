<?php

namespace DataSource\Http\Requests\Admin\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DataSource\Entities\Course\Course;

class Update extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       $mergeArray = [];
 
       return array_merge([
        'first_name' => ['required','string'],
        'last_name' => ['required','string'],
        'email' => ['required','email'],
        'password'=>[''],
        'model_id' => ['integer','required'],
        'city' => ['required','string'],
        'country' => ['required','string'],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],


    ], $mergeArray);
        return[];
    }
}

