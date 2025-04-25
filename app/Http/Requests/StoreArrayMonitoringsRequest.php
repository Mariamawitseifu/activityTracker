<?php

namespace App\Http\Requests;

use App\Models\Monitoring;
use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class StoreArrayMonitoringsRequest extends FormRequest
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
        
        // $myplanCount = Plan::count();

        return [
            'monitorings' => 'required|array',
            'month' => 'required|date_format:Y-m|before_or_equal:now', 
            'monitorings.*.plan_id' => 'required|uuid|exists:plans,id|distinct',
            'monitorings.*.actual_value' => 'required|numeric',
        ];
    }
}
