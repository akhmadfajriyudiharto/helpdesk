<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class OutgoingMailUpdateRequest extends FormRequest
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
            'mail_from_address' => ['required', 'max:255'],
            'mail_from_name' => ['required', 'max:255'],
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
            'mail_from_address.required' => __('The :attribute field is required', ['attribute' => __('from address')]),
            'mail_from_address.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('from address'), 'max' => 255]),

            'mail_from_name.required' => __('The :attribute field is required', ['attribute' => __('from name')]),
            'mail_from_name.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('from name'), 'max' => 255]),
        ];
    }
}
