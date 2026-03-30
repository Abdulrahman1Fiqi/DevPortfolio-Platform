<?php

namespace App\Http\Requests\Developer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string','max:2000'],

            'tech_stack' => ['nullable','array'],
            'tech_stack.*' => ['string','max:50'],

            'thumbnail' => ['nullable','image','max:2048'],
            'demo_url' => ['nullable','url','max:255'],

            'repo_url' => ['nullable','url','max:255','regex:/^https:\/\/github\.com\/.+/'],

            'is_featured' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'repo_url.regex' => 'The repository URL must be a valid GitHub URL (https://github.com/...)',
        ];
    }

    public function attributes(): array
    {
        return [
            'repo_url' => 'repository URL',
            'tech_stack.*' => 'technology',
        ];
    }
}
