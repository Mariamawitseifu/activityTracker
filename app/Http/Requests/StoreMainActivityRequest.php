<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMainActivityRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'initiative_id' => ['required', 'exists:initiatives,id'],
            'type' => ['required', 'string', 'in:Main Activity,KPI'],
            'weight' => ['required', 'integer'],
            'target' => ['required', 'integer'],
            'measuring_unit_id' => ['required', 'uuid', 'exists:measuring_units,id'],
        ];
    }
}
