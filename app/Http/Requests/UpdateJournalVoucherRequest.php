<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJournalVoucherRequest extends FormRequest
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
            'voucher_type_id' => 'required',
            'date' => 'required',
            'company_id' => 'required',
            'account_title_id' => 'required',
            'location_id' => 'required',
            'cheque_no' => 'required',
            'cheque_date' => 'required',
            'pay_to' => 'required'
        ];
    }
}
