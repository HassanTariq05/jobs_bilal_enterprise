<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFuelPurchaseRequest extends FormRequest
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
            'party_id' => 'required',
            'fuel_type_id' => 'required',
            'tank_id' => 'required',
            'qty' => 'required',
            'rate' => 'required',
            'amount' => 'required',
            'delivery_date' => 'required',
            'freight_charges' => 'required'
        ];
    }
}
