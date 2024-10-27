<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartyRequest extends FormRequest
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
        return [
            'party_type_id' => 'required',
            'short_name' => 'required|unique:parties',
            'title' => 'required|unique:parties',
            'email' => 'required|unique:parties',
            'address' => 'required',
            'contact' => 'required',
            //'contact_person' => 'required',
            //'bank_name' => 'required',
            //'iban' => 'required|unique:parties',
        ];
    }
}
