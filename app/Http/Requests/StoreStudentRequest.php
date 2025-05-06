<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'course_id' => 'required|exists:courses,id',

            'base_price' => 'required|numeric|min:0',
            'sold_price' => 'required|numeric|min:0|lte:base_price',
            'discount' => 'nullable|numeric|min:0|max:100',
            'enrolment_fee' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:full,emi',

            'emi_months' => 'required_if:payment_mode,emi|nullable|integer|min:1',
            'emi_amount' => 'required_if:payment_mode,emi|nullable|numeric|min:0',
            'emi_start_date' => 'required_if:payment_mode,emi|nullable|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'emi_months.required_if' => 'EMI months are required when payment mode is EMI.',
            'emi_amount.required_if' => 'EMI amount is required when payment mode is EMI.',
            'emi_start_date.required_if' => 'EMI start date is required when payment mode is EMI.',
        ];
    }
}
