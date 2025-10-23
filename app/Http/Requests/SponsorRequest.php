<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SponsorRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {

        $sponsorId = $this->route('sponsor')?->id ?? $this->route('sponsor');

        return [
            'name' => ['required', 'string', 'max:255'],
            'contribution' => ['required', Rule::in(['financial', 'material', 'logistical'])],
            'email' => ['required', 'email', 'max:255', Rule::unique('sponsors', 'email')->ignore($sponsorId)],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{6,30}$/'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo' => [
                $this->isMethod('post') ? 'nullable' : 'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The sponsor name is required.',
            'contribution.required' => 'The contribution type is required.',
            'contribution.in' => 'The selected contribution type is invalid.',
            'email.required' => 'The email address is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number contains invalid characters.',
            'website.url' => 'The website URL format is invalid (e.g., https://example.com).',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a file of type: jpg, jpeg, png, webp.',
            'logo.max' => 'The logo may not be greater than 2MB.',
        ];
    }
}
