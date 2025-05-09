<?php

namespace App\Http\Requests;

use App\Constants\ChargeType;
use App\Constants\CurrencyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendPaymentRequest extends FormRequest
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
        # These are initial validation, can be more accurate and specific based on the requirements.
        return [
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['required', 'string', Rule::in(CurrencyType::values())],
            'account_number' => ['required', 'string', 'max:255'],
            'beneficiary_name' => ['required', 'string', 'max:30'],
            'beneficiary_account_number' => ['required', 'string', 'min:20', 'max:25'],
            'beneficiary_bank_code' => ['required', 'string', 'min:5', 'max:10'],
            'notes' => ['nullable', 'array'],
            'payment_type' => ['required', 'numeric'],
            'charge_details' => ['required', 'string', Rule::in(ChargeType::values())],
        ];
    }

    public function messages(): array
    {
        # We can add custom messages here for each field if not passed the validation needed
        return [];
    }
}
