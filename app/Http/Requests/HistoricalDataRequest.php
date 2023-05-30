<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricalDataRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_symbol' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date|before_or_equal:' . now()->format('Y-m-d'),
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:' . now()->format('Y-m-d'),
            'email' => 'required|email',
        ];
    }
}
