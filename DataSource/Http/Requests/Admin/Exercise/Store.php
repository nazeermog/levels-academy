<?php

namespace DataSource\Http\Requests\Admin\Exercise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        'col_count' => [''],
        'numbers' => ['required'],
        'practice_id' => ['required', 'numeric'],
        'code' => ['required'],
        'book_id' => ['required'],
        'row' => ['required'],
        'page' => ['required'],
    ], $mergeArray);
        return[];
    }
}

