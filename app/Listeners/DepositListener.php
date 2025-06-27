<?php

namespace App\Listeners;
 
use App\Enums\TransactionCategory;
use App\Events\DepositEvent;
use App\Services\TransactionService; 

class DepositListener
{
    public function __construct(private readonly TransactionService $transactionService)
    { 
    }

    public function handle(DepositEvent $event): void
    {
        if($event->transactionDto->category != TransactionCategory::DEPOSIT->value){
            return;
        }
        $this->transactionService->createTransaction($event->transactionDto);
        $account = $event->lockedAccount;
        $account->balance += $event->transactionDto->amount;
        $account->save();
        $account->refresh();
        $this->transactionService->updateTransaction($event->transactionDto->reference, $account->balance);
    }
}
