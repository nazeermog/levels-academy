<?php

namespace DataSource\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DataSource\Entities\Lesson\Lesson;

class Update extends FormRequest
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
           $mergeArray['desc-' . $locale] = ['required', 'string'];
           $mergeArray['attachment_name-' . $locale] = ['nullable', 'string'];

       }
       return array_merge([
        'url' => ['required'],
        'attachment' => ['nullable'],
        'time' => ['numeric','required'],
        'model_id' => ['integer','required'],
    ], $mergeArray);
        return[];
    }
}

