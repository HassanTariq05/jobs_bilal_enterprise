<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateBankAccountRequest extends FormRequest
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
        $table = 'bank_accounts';
        return [
            'bank' => 'required',
            'address' => 'required',
            'title' => [
                'required',
                Rule::unique("$table", 'title')->ignore($id),
            ],
            'iban' => [
                'required',
                Rule::unique("$table", 'iban')->ignore($id),
            ],            
            'company_id' => 'required',
        ];
    }
}
