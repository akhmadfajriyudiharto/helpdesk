<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SeoUpdateRequest extends FormRequest
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
            'meta_home_title' => ['required', 'max:255'],
            'meta_keywords' => ['required', 'max:255'],
            'meta_description' => ['required', 'max:255'],
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
            'meta_home_title.required' => __('The :attribute field is required', ['attribute' => __('home title')]),
            'meta_home_title.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('home title'), 'max' => 255]),

            'meta_keywords.required' => __('The :attribute field is required', ['attribute' => __('keywords')]),
            'meta_keywords.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('keywords'), 'max' => 255]),

            'meta_description.required' => __('The :attribute field is required', ['attribute' => __('description')]),
            'meta_description.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('description'), 'max' => 255]),
        ];
    }
}
