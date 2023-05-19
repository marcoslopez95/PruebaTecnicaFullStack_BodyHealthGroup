<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class ExternalReferenceCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:external_references',
            'url'  => 'required|url',
        ];
    }
}
