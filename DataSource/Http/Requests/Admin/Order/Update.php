<?php

namespace DataSource\Http\Requests\Admin\Order;

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

        return array_merge([
            'status' => ['required'],
            'model_id' => ['integer', 'required'],
        ], $mergeArray);
        return [];
    }
}
