<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'main_activity_id' => ['nullable', 'exists:main_activities,id'],
            'main_activity_id.*' => ['nullable', 'array', 'exists:main_activities,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'parent_id' => ['nullable', 'exists:plans,id'],
        ];
    }
}
