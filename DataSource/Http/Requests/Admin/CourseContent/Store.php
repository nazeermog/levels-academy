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
            'arrayData' => ['array', 'required'],
            'arrayData.*.ordering' => ['numeric', 'required'],
            'arrayData.*.type_id' => ['numeric', 'required'],
            'arrayData.*.type' => ['in:Quiz,PracticeType,Lesson'],
            'price' => ['required'],
        ], $mergeArray);
    }
}

