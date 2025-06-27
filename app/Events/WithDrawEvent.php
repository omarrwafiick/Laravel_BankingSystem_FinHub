<?php

namespace App\Events;

use App\DTOs\AccountDto;
use App\DTOs\TransactionDto;
use App\Models\Account; 
use Illuminate\Broadcasting\InteractsWithSockets; 
use Illuminate\Broadcasting\PrivateChannel; 
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WithDrawEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public function __construct(
        public readonly TransactionDto $transactionDto, 
        public readonly AccountDto $accountDto, 
        public readonly Account $lockedAccount)
    {
        //
    }
 
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('withdrawing'),
        ];
    }
}
