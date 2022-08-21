<?php

namespace App\Http\Requests\Dashboard\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'body' => ['required'],
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
            'user_id.required' => __('The :attribute field is required', ['attribute' => __('customer')]),
            'user_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('customer')]),

            'subject.required' => __('The :attribute field is required', ['attribute' => __('subject')]),
            'subject.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('subject'), 'max' => 255]),

            'department_id.required' => __('The :attribute field is required', ['attribute' => __('department')]),
            'department_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('department')]),

            'status_id.required' => __('The :attribute field is required', ['attribute' => __('status')]),
            'status_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('status')]),

            'priority_id.required' => __('The :attribute field is required', ['attribute' => __('priority')]),
            'priority_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('priority')]),

            'body.required' => __('The :attribute field is required', ['attribute' => __('body')]),
        ];
    }
}
