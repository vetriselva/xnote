<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
                ->ignore($this->contact?->id)
                ->where(function ($query) {
                    $query->where('tenant_id', auth()->user()->tenant_id);
                }),
            ],
            'email'   => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'has_reminder'=> 'boolean',
            'reminder_at'   => 'nullable|date',
            'reminder_note' => 'nullable|string|max:255',
        ];
    }
}
