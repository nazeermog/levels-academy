<?php

namespace DataSource\Http\Requests\Admin\CoursePath;

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
       }
       return array_merge([
        'course_id.*' => ['numeric','required'],
        'taxonomy_id' => ['numeric','required'],
        'photo'=>['image','mimes:jpeg,png,jpg,svg','required'],
    ], $mergeArray);
        return[];
    }
}

