<?php

namespace Modules\Instructor\Http\Requests;

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
            'student_id' => ['required', 'exists:students,user_id'],
            'note' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ];
    }
}
