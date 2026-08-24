<?php

namespace DataSource\Http\Requests\Admin\Instructor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use DataSource\Entities\Instructor\Instructor;

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
            $mergeArray['spec-' . $locale] = ['required', 'string'];
            $mergeArray['about-' . $locale] = ['required', 'string'];
            $mergeArray['country-' . $locale] = ['required', 'string'];
        }
        return array_merge([
            'avatar' => ['required'],
            'user_id' => ['required', 'numeric'],
            'organization_id' => ['required', 'exists:organizations,id'],

        ], $mergeArray);
        return [];
    }
}
