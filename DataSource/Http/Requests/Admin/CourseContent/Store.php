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
       $mergeArray = [];
       foreach (localeSupported() as $locale) {
           $mergeArray['title-' . $locale] = ['required', 'string'];
           $mergeArray['slug-' . $locale] = ['required', 'string'];
       }
       return array_merge([
        //  'boxArr' => ['array', 'required'],
        'boxArr.*.ordering' => ['numeric', 'required'],
        'boxArr.*.type.id' => ['numeric', 'required'],
        'boxArr.*.type.type' => ['in:Quizzes,Practices,Lessons'],
        'taxonomy_id' => ['numeric','required'],
        'photo'=>['image','mimes:jpeg,png,jpg,svg','required'],
        'price' => ['required'],
    ], $mergeArray);
        return[];
    }
}

