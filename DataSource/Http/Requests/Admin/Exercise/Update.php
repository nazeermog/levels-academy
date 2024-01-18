<?php

namespace DataSource\Http\Requests\Admin\Exercise;

use Illuminate\Foundation\Http\FormRequest;

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
        'col_count' => [''],
        'numbers' => ['required'],
        'practice_id' => ['required', 'numeric'],
        'code' => ['required'],
        'book_id' => ['required'],
        'model_id'=> ['required'],
    ], $mergeArray);
        return[];
    }
}

