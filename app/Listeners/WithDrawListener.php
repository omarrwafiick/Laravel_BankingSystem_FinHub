<?php

namespace App\Listeners;

use App\Enums\TransactionCategory;
use App\Events\WithDrawEvent;
use App\Services\TransactionService; 

class WithDrawListener
{ 
    public function __construct(private readonly TransactionService $transactionService)
    { 
    }
 
    public function handle(WithDrawEvent $event): void
    {
        if($event->transactionDto->category != TransactionCategory::WITHDRAW->value){
            return;
        }
        $this->transactionService->createTransaction($event->transactionDto);
        $account = $event->lockedAccount;
        $account->balance -= $event->transactionDto->amount;
        $account->save();
        $account->refresh();
        $this->transactionService->updateTransaction($event->transactionDto->reference, $account->balance);
    }
}
