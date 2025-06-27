<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionHistoryRequest extends FormRequest
{ 
    public function authorize(): bool
    {
        return true;
    }
 
    public function rules(): array
    {
        return [
            'account_number' => ['required', 'exists:accounts,account_number'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
            'category' => ['nullable', Rule::in(['deposit', 'withdraw'])],
        ];
    }
}
