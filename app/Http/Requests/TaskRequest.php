<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'plan' => 'required',
            'actual' => 'required',
            'next_plan' => 'required',
            'comment' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'plan.required' => trans('trainee.request.required'),
            'actual.required' => trans('trainee.request.required'),
            'next_plan.required' => trans('trainee.request.required'),
            'comment.required' => trans('trainee.request.required'),
        ];
    }
}
