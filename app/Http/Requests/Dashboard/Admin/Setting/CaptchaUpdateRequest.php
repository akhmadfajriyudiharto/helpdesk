<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class CaptchaUpdateRequest extends FormRequest
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
            'recaptcha_enabled' => ['required'],
            'recaptcha_public' => ['required_if:recaptcha_enabled,true'],
            'recaptcha_private' => ['required_if:recaptcha_enabled,true'],
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
            'recaptcha_enabled.required' => __('The :attribute field is required', ['attribute' => __('recaptcha enabled')]),

            'recaptcha_public.required_if' => __('The :attribute field is required', ['attribute' => __('recaptcha public')]),

            'recaptcha_private.required_if' => __('The :attribute field is required', ['attribute' => __('recaptcha private')]),
        ];
    }
}
