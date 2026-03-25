<?php

namespace App\Http\Requests\Developer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required','string','max:255'],

            'headline' => ['nullable','string','max:100'],
            'bio' => ['nullable','string','max:1000'],
            'location' => ['nullable','string','max:100'],

            'avatar'=>['nullable','image','max:2048'],

            'social_links.github' => ['nullable','url','max:255'],
            'social_links.linkedin' => ['nullable','url','max:255'],
            'social_links.website' => ['nullable','url','max:255'],
            'social_links.twitter' => ['nullable','url','max:255'],
        ];
    }



    public function messages(): array
    {
        return [
            'avatar.image' => 'The profile photo must be an image file (jpg, png, webp, etc.)',
            'avatar.max'   => 'The profile photo must not be larger than 2MB.',

            'social_links.github.url'   => 'GitHub must be a valid URL (e.g. https://github.com/username).',
            'social_links.linkedin.url' => 'LinkedIn must be a valid URL (e.g. https://linkedin.com/in/username).',
            'social_links.website.url'  => 'Website must be a valid URL (e.g. https://yoursite.com).',
            'social_links.twitter.url'  => 'Twitter must be a valid URL (e.g. https://twitter.com/username).',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'                  => 'full name',
            'headline'              => 'headline',
            'bio'                   => 'bio',
            'location'              => 'location',
            'avatar'                => 'profile photo',
            'social_links.github'   => 'GitHub URL',
            'social_links.linkedin' => 'LinkedIn URL',
            'social_links.website'  => 'website URL',
            'social_links.twitter'  => 'Twitter URL',
        ];
    }
}
