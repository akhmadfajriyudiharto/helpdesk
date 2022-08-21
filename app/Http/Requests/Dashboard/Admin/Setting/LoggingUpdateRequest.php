<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class LoggingUpdateRequest extends FormRequest
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
            'sentry_dsn' => ['max:255'],
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
            'sentry_dsn.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('sentry dsn'), 'max' => 255]),
        ];
    }
}
