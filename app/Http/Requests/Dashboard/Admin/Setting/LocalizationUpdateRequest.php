<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class LocalizationUpdateRequest extends FormRequest
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
            'app_timezone' => ['required', 'max:255'],
            'app_locale' => ['required', 'exists:languages,locale', 'max:255'],
            'app_date_locale' => ['required', 'max:255'],
            'app_date_format' => ['required', 'max:255'],
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
            'app_timezone.required' => __('The :attribute field is required', ['attribute' => __('timezone')]),
            'app_timezone.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('timezone'), 'max' => 255]),

            'app_locale.required' => __('The :attribute field is required', ['attribute' => __('locale')]),
            'app_locale.exists' => __('The selected :attribute is invalid', ['attribute' => __('locale')]),
            'app_locale.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('locale'), 'max' => 255]),

            'app_date_locale.required' => __('The :attribute field is required', ['attribute' => __('date locale')]),
            'app_date_locale.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('date locale'), 'max' => 255]),

            'app_date_format.required' => __('The :attribute field is required', ['attribute' => __('date format')]),
            'app_date_format.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('date format'), 'max' => 255]),
        ];
    }
}
