<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateFleetRequest extends FormRequest
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
        $table = 'fleets';
        return [
            'fleet_manufacturer_id' => 'required',
            'fleet_type_id' => 'required',
            'registration_number' => [
                'required',
                Rule::unique("$table", 'registration_number')->ignore($id),
            ],
            'chassis_number' => [
                'required',
                Rule::unique("$table", 'chassis_number')->ignore($id),
            ],
            'engine_number' => [
                'required',
                Rule::unique("$table", 'engine_number')->ignore($id),
            ],
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
