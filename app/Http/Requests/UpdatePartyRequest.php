<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdatePartyRequest extends FormRequest
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
        $id = $this->route('id');
        $table = 'parties';
        return [
            'party_type_id' => 'required',
            'short_name' => [
                'required',
                Rule::unique("$table", 'short_name')->ignore($id),
            ],
            'title' => [
                'required',
                Rule::unique("$table", 'title')->ignore($id),
            ],
            'email' => [
                'required',
                Rule::unique("$table", 'email')->ignore($id),
            ],
            'address' => 'required',
            'contact' => 'required',
            //'contact_person' => 'required',
            //'bank_name' => 'required',
            //'iban' => 'required',
        ];
    }
}
