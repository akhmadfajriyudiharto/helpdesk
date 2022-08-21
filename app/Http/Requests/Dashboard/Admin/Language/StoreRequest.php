<?php

namespace App\Http\Requests\Dashboard\Admin\Language;

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
            'name' => ['required'],
            'locale' => ['required', 'min:1', 'max:5', 'unique:languages'],
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

            'locale.required' => __('The :attribute field is required', ['attribute' => __('locale')]),
            'locale.min' => __('The :attribute must be at least :min characters', ['attribute' => __('locale'), 'min' => 1]),
            'locale.max' => __('The :attribute may not be greater than :max characters', ['attribute' => __('locale'), 'max' => 5]),
            'locale.unique' => __('The :attribute has already been taken', ['attribute' => __('locale')]),
        ];
    }
}
