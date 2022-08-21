<?php

namespace App\Http\Requests\Dashboard\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketReplyRequest extends FormRequest
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
            'body' => ['required'],
            'status_id' => ['required', 'exists:statuses,id'],
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
            'body.required' => __('The :attribute field is required', ['attribute' => __('body')]),

            'status_id.required' => __('The :attribute field is required', ['attribute' => __('status')]),
            'status_id.exists' => __('The selected :attribute is invalid', ['attribute' => __('status')]),
        ];
    }
}
