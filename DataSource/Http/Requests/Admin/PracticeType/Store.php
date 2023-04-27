<?php

namespace DataSource\Http\Requests\Admin\PracticeType;

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
            'seconds_speed' => ['required', 'numeric'],
            'card_number' => ['required', 'numeric'],
            'range_number_from' => ['required', 'numeric'],
            'range_number_to' => ['required', 'numeric'],
            'practice_id' => ['required', 'numeric', 'exists:practices,id'],
        ], $mergeArray);
    }
}

