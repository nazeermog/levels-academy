<?php

namespace DataSource\Http\Requests\Admin\Blog;

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
        foreach (localeSupported() as $locale) {
            $mergeArray['title-' . $locale] = ['required', 'string'];
            $mergeArray['desc-' . $locale] = ['required', 'string'];
        }
        return array_merge([
            'photo' => ['required'],
            'user_id' => ['required'],
        ], $mergeArray);
        return [];
    }
}
