<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
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
        $table = 'locations';
        return [
            'title' => [
                'required',
                Rule::unique("$table", 'title')->ignore($id),
            ],
            'short_name' => [
                'required',
                Rule::unique("$table", 'short_name')->ignore($id),
            ],
            'address' => [
                'required',
                Rule::unique("$table", 'address')->ignore($id),
            ],
        ];
    }
}
