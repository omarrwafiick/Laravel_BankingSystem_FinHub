<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithDrawRequest extends FormRequest
{ 
    public function authorize(): bool
    {
        return false;
    }
 
    public function rules(): array
    {
        return [
            'account_number' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['required'],
            'transfer_id' => ['required'], 
        ];
    }
}
