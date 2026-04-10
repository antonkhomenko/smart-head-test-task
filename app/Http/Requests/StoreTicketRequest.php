<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'email' => 'nullable|email|max:255',

            'subject' => 'required|string|max:255',
            'message' => 'required|string',

            'files' => 'nullable|array',
            'files.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf',
        ];
    }
}
