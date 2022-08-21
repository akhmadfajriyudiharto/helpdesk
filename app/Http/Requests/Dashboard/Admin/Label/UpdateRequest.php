<?php

namespace App\Http\Requests\Dashboard\Admin\Label;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'color' => ['required', 'regex:/^#(\d|a|b|c|d|e|f){6}$/i'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('The :attribute field is required', ['attribute' => __('name')]),
            'name.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('name'), 'max' => 255]),

            'color.required' => __('The :attribute field is required', ['attribute' => __('color')]),
            'color.regex' => __('The :attribute format is invalid', ['attribute' => __('color')]),
        ];
    }
}
