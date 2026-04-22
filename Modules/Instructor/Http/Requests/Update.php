<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,user_id',
            'note'       => 'required|string|max:1000',
            'rating'     => 'required|integer|between:1,5',
        ];
    }
}
