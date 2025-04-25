<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => 'nullable|email|unique:' . User::class . ',email',
            'username' => 'required|string|max:255',
            'phone' => 'nullable|starts_with:251|digits:12|unique:' . User::class . ',phone',
            'started_date' => 'required|date',
            'end_date' => 'nullable|date',
            'unit_id' => 'required|uuid|exists:units,id',
            'roles' => 'nullable|array',
            'roles.*' => 'required|uuid|exists:' . Role::class . ',uuid',
        ];
    }
}
