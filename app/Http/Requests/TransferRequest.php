<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{ 
    public function authorize(): bool
    {
        return true;
    }
  
    public function rules(): array
    {
        return [
            'sender_account_id' => ['required', 'string', 'min:3', 'max:200'],
            'recipient_account_id' => ['required', 'string', 'min:3', 'max:200'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
