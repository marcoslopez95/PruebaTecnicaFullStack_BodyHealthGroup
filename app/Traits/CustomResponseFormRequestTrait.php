<?php

namespace App\Traits;

trait CustomResponseFormRequestTrait
{
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $message = collect($validator->errors())->flatten();
        $response = customResponseError(422, 'error validation', $message, 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
