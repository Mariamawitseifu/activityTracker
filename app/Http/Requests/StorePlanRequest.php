<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
            'main_activities' => ['required', 'array'],
            'main_activities.*' => ['required', 'exists:plans,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'fiscal_year_id' => ['required', 'exists:fiscal_years,id'],
        ];
    }
}
