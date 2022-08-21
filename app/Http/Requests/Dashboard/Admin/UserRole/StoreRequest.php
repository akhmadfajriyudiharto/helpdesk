<?php

namespace App\Http\Requests\Dashboard\Admin\UserRole;

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
            'name' => ['required', 'max:255', 'unique:user_roles,name'],
            'dashboard_access' => ['required'],
            'permissions' => ['array']
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
            'name.unique' => __('The :attribute has already been taken', ['attribute' => __('name')]),

            'dashboard_access.required' => __('The :attribute field is required', ['attribute' => __('dashboard access')]),

            'permissions.array' => __('The :attribute must be an array', ['attribute' => __('permissions')]),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $permissions = [];
        foreach ($this->get('permissions') as $key => $value) {
            if ($value) {
                $permissions[] = $key;
            }
        }
        $this->merge([
            'permissions' => $permissions,
        ]);
    }
}
