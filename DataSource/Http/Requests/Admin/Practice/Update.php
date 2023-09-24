<?php

namespace DataSource\Http\Requests\Admin\Practice;

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
        foreach (localeSupported() as $locale) {
            $mergeArray['title-' . $locale] = ['required', 'string'];
        }
        return array_merge([
         'model_id' => ['integer','required'],
     ], $mergeArray);
         return[];
     }
}

