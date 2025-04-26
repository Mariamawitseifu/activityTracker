<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'email' => 'nullable|email',
            'phone' =>  'nullable|starts_with:251|digits:12',
            'started_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'unit_id' => 'nullable|uuid|exists:units,id',
            'roles' => 'nullable|array',
            'roles.*' => 'required|uuid',
        ];
    }
}
