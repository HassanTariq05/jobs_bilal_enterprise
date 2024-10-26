<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFleetRequest extends FormRequest
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
            'fleet_manufacturer_id' => 'required',
            'fleet_type_id' => 'required',
            'registration_number' => 'required|unique:fleets',
            'chassis_number' => 'required|unique:fleets',
            'engine_number' => 'required|unique:fleets',
            'model' => 'required',
            'horsepower' => 'required',
            'loading_capacity' => 'required',
            'registration_city' => 'required',
            'ownership' => 'required',
            'lifting_capacity' => 'required',
            'diesel_opening_inventory' => 'required',
        ];
    }
}
