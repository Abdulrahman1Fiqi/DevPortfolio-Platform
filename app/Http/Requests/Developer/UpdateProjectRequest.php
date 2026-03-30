<?php

namespace App\Http\Requests\Developer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  auth()->check() && auth()->user()->isDeveloper();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return (new StoreProjectRequest())->rules();
    }
    
    public function messages(): array
    {
        return (new StoreProjectRequest())->messages();
    }

    public function attributes(): array
    {
        return (new StoreProjectRequest())->attributes();
    }
}
