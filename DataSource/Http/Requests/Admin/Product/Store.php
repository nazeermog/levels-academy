<?php

namespace DataSource\Http\Requests\Admin\Product;

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
            $mergeArray['name-' . $locale] = ['required', 'string'];
            $mergeArray['desc-' . $locale] = ['nullable', 'string'];
        }
        return array_merge([
            'category_product_id' =>['required'],
            'unit' => ['required'],
            'photo' => ['required'],
            'price' => ['numeric', 'required'],
        ], $mergeArray);
        return [];
    }
}
