<?php

namespace App\Events;

use App\DTOs\AccountDto;
use App\DTOs\TransactionDto;
use App\Models\Account; 
use Illuminate\Broadcasting\InteractsWithSockets; 
use Illuminate\Broadcasting\PrivateChannel; 
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public function __construct(
        public TransactionDto $transactionDto, 
        public AccountDto $accountDto, 
        public Account $lockedAccount)
    {}
 
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('dipositing'),
        ];
    }
}
