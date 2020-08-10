<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'unique:subjects|max:50',
            'description' => 'required',
            'time' => 'required|numeric|min:2',
            'course_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => trans('supervisor.request.image_required'),
            'image.mimes' => trans('supervisor.request.image_type'),
            'image.max' => trans('supervisor.request.image_large'),
            'title.max' => trans('supervisor.request.title_large'),
            'description.required' => trans('supervisor.request.description_required'),
            'time.required' => trans('supervisor.request.time_required'),
            'time.min' => trans('supervisor.request.time_min'),
        ];
    }
}
