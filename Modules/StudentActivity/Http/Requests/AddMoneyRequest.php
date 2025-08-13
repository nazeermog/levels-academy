<?php

namespace Modules\StudentActivity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMoneyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => ['required', 'numeric', 'min:0.01'],
            'desc' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => 'Please enter the amount to add.',
            'price.numeric' => 'The amount must be a valid number.',
            'price.min' => 'The amount must be greater than 0.',
        ];
    }
}
