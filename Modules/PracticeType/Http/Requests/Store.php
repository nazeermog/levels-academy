<?php

namespace Modules\PracticeType\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'practice_id' => ['required', 'numeric', 'exists:practice_types,id'],
            'student_id' => ['required', 'numeric', 'exists:students,user_id'],
            'is_true' => ['required'],
            'seconds_speed' => [],
            'result_student' => ['required', 'numeric'],
            'result_true' => ['required', 'numeric'],
            'level_title' => ['required'],
            'card_number' => [],
            'range_number_from' => ['required','numeric'],
            'range_number_to' => ['required','numeric'],
        ];
    }
}

