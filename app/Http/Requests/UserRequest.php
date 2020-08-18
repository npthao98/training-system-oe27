<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fullname' => 'required',
            'email' => 'required|unique:users,email',
            'birthday' => 'required',
            'gender' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => trans('trainee.request.required'),
            'email.required' => trans('trainee.request.required'),
            'image.mimes' => trans('supervisor.request.image_type'),
            'image.max' => trans('supervisor.request.image_large'),
            'birthday.required' => trans('trainee.request.required'),
            'gender.required' => trans('trainee.request.required'),
        ];
    }
}
