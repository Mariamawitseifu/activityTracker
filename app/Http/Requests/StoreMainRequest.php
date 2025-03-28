<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMainRequest extends FormRequest
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
            'inititative_id' => ['required', 'exists:inititatives,id'],
            'type'=> ['required', 'string', 'in:main activity,KPI'],
            'weight' => ['required', 'integer'],
            'measuring_unit_id' => ['required', 'uuid', 'exists:measuring_units,id'],
        ];
    }
}
