<?php

namespace App\Http\Requests;

class StoreTaskRequest extends TaskBaseRequest
{
    public function messages()
    {
        return [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => __('task.entity')
            ])
        ];
    }
}
