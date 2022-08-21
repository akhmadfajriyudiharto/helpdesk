<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class GeneralUpdateRequest extends FormRequest
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
            'app_url' => ['required', 'url', 'max:255'],
            'app_name' => ['required', 'max:255'],
            'app_https' => ['required', 'boolean'],
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
            'app_url.required' => __('The :attribute field is required', ['attribute' => __('app url')]),
            'app_url.url' => __('The :attribute format is invalid', ['attribute' => __('app url')]),
            'app_url.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('app url'), 'max' => 255]),

            'app_name.required' => __('The :attribute field is required', ['attribute' => __('app name')]),
            'app_name.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('app name'), 'max' => 255]),

            'app_https.required' => __('The :attribute field is required', ['attribute' => __('force https')]),
            'app_https.boolean' => __('The :attribute field must be true or false', ['attribute' => __('force https')]),
        ];
    }
}
