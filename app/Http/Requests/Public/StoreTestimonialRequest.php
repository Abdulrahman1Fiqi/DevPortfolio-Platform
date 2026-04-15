<?php

namespace App\Http\Requests\Public;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'submitter_name' => ['required', 'string', 'max:100'],
            'submitter_role' => ['nullable', 'string', 'max:100'],
            'company'        => ['nullable', 'string', 'max:100'],
            'message'        => ['required', 'string', 'min:20', 'max:1000'],
            'rating'         => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.min' => 'Your testimonial must be at least 20 characters.',
            'rating.min'  => 'Rating must be between 1 and 5 stars.',
            'rating.max'  => 'Rating must be between 1 and 5 stars.',
        ];
    }
}
