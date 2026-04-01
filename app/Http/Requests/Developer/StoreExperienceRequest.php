<?php

namespace App\Http\Requests\Developer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isDeveloper();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company' => ['required','string','max:100'],
            'role' => ['required','string','max:100'],
            'start_date' => ['required','date','before_or_equal:today'],
            'end_date' => ['nullable','date','after_or_equal:start_date'],
            'description' => ['nullable','string','max:1000'],
        ];
    }

    public function messages(): array
    {
        return[
            'start_date.before_or_equal' =>'Start date cannot be in the future.',
            'end_date.after_or_equal' =>'End date must be after the start date.',
        ];
    }
}
