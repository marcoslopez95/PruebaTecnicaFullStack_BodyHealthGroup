<?php

namespace App\Http\Requests\Writer;

use Illuminate\Foundation\Http\FormRequest;

class PublicationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create publication') || isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'content'             => 'required|string|max:255',
            'labels'              => 'nullable|array',
            'labels.*'            => 'string|max:15',
            'region_id'           => 'nullable|exists:regions,id',
            'external_references' => 'nullable|array',
            'external_references.*' => 'integer|exists:external_references,id',
            'publication_category_id'  => 'required|integer|exists:publication_categories,id',
        ];
    }
}
