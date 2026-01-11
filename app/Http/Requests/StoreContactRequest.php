<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('contacts', 'phone')
                    ->where(fn($query) => $query->where('tenant_id', auth()->user()->tenant_id)),
            ],
            'email'   => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes'   => 'nullable|string|max:1000',
            'reminder_at'   => 'nullable|date',
            'has_reminder' => 'boolean',
            'reminder_note' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Contact name is required',
            'email.email'   => 'Please enter a valid email address',
        ];
    }
}
