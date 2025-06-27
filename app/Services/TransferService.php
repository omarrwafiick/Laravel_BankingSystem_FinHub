<?php

namespace App\Services;

use App\DTOs\TransferDto;
use App\Enums\TransferStatus;
use App\Models\Transfer; 
 
class TransferService  
{ 
    public function createTransfer(TransferDto $transferDto):int{
        $transfer = Transfer::create([
        'sender_account_id' => $transferDto->sender_account_id,
        'recipient_account_id' => $transferDto->recipient_account_id,
        'amount' => $transferDto->amount,
        'reference' => $transferDto->reference,
        'status' => TransferStatus::COMPLETED->value,  
        ]);
        return $transfer->id;
    }
}