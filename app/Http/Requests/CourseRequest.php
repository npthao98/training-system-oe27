<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'content_description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => trans('supervisor.request.image_required'),
            'image.mimes' => trans('supervisor.request.image_type'),
            'image.max' => trans('supervisor.request.image_large'),
            'title.max' => trans('supervisor.request.title_large'),
        ];
    }
}
