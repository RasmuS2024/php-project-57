<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLabelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $labelId = $this->route('label')->id;

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('labels')->ignore($labelId)
            ],
            'description' => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => __('label.entity')
            ])
        ];
    }
}
