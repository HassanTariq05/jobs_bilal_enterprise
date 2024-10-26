<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFuelIssueRequest extends FormRequest
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
            'tank_id' => 'required',
            'fleet_id' => 'required',
            'operation_id' => 'required',
            'fill_date' => 'required',
            'qty' => 'required',
            'driver' => 'required',
            'odometer_reading' => 'required'
        ];
    }
}
