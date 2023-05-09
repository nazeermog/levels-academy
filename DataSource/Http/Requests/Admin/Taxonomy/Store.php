<?php

namespace DataSource\Http\Requests\Admin\Taxonomy;

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
            $mergeArray['desc-' . $locale] = ['nullable', 'string'];
        }
        return $mergeArray;
    }
}

