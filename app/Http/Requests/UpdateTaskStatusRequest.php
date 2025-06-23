<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskStatusRequest extends FormRequest
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
        $taskStatusId = $this->route('task_status')->id;

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('task_statuses')->ignore($taskStatusId)
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => __('status.entity')
            ])
        ];
    }
}
