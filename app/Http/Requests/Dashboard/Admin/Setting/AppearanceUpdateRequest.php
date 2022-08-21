<?php

namespace App\Http\Requests\Dashboard\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class AppearanceUpdateRequest extends FormRequest
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
            'icon' => ['image', 'max:1000', 'dimensions:ratio=1/1'],
            'background' => ['image', 'max:2000'],
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
            'icon.image' => __('The file has to be an image', ['attribute' => __('icon')]),
            'icon.max' => __('The :attribute may not be greater than :max kilobytes', ['attribute' => __('icon'), 'max' => 1000]),
            'icon.dimensions' => __('The :attribute has invalid image dimensions', ['attribute' => __('icon')]),

            'background.image' => __('The file has to be an image', ['attribute' => __('background')]),
            'background.max' => __('The :attribute may not be greater than :max kilobytes', ['attribute' => __('background'), 'max' => 2000]),
            'background.dimensions' => __('The :attribute has invalid image dimensions', ['attribute' => __('background')])
        ];
    }
}
