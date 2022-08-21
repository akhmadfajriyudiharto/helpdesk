<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
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
            'current_password.required' => __('The :attribute field is required', ['attribute' => __('Current password')]),

            'password.required' => __('The :attribute field is required', ['attribute' => __('password')]),
            'password.min' => __('The :attribute must be at least :min characters', ['attribute' => __('password'), 'min' => 6]),
            'password.confirmed' => __('The :attribute confirmation does not match', ['attribute' => __('password')])
        ];
    }
}
