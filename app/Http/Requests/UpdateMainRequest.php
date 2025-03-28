<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMainRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:255'],
            'inititative_id' => ['nullable', 'exists:inititives,id'],
            'main_type'=> ['nullable', 'string', 'in:main activity,KPI'],
            'weight' => ['nullable', 'integer'],
            'measuring_unit' => ['nullable', 'string'],
        ];
    }
}
