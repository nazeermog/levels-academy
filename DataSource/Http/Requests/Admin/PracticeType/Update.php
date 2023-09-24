<?php

namespace DataSource\Http\Requests\Admin\PracticeType;

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
            'seconds_speed' => [''],
            'card_number' => [''],
            'col_count' => [''],
            'numbers_to_sum' => [''],
            'range_number_from' => ['required','numeric'],
            'range_number_to' => ['required','numeric'],
            'coins_taken'=> ['required','numeric'],
            'level_id' => ['required','numeric'],
            'practice_id' => ['required', 'numeric', 'exists:practice_types,id'],
            'turns' => [''],
            'timer' => [''],
            'model_id' => ['integer','required'],
        ], $mergeArray);
    }
}

