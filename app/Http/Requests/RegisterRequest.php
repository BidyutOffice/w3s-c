<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => ["required", "string", "max:100"],
            "email" => ["required", "email", "max:255", "unique:users,email"],
            "password" => ["required", "string", "min:8", "max:20", "confirmed"],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "The name field is required.",
            "name.string" => "The name must be a valid string.",
            "name.max" => "The name must not exceed 100 characters.",

            "email.required" => "The email field is required.",
            "email.email" => "Please provide a valid email address.",
            "email.max" => "The email must not exceed 255 characters.",
            "email.unique" => "This email is already registered.",

            "password.required" => "The password field is required.",
            "password.string" => "The password must be a valid string.",
            "password.min" => "The password must be at least 8 characters long.",
            "password.max" => "The password must not exceed 20 characters.",
            "password.confirmed" => "The password confirmation does not match.",
        ];
    }
}
