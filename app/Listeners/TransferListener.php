<?php

namespace App\Listeners;

use App\DTOs\AccountDto;
use App\DTOs\TransactionDto;
use App\Events\TransferEvent;
use App\Services\TransactionService;
use App\Services\TransferService; 

class TransferListener
{ 
    public function __construct(
        private readonly TransactionService $transactionService,
        public readonly TransferService $transferService)
    { 
    }
 
    public function handle(TransferEvent $event): void
    {
        $dto = $event->transferDto;
        $sender = $event->sender;
        $recipient = $event->recipient;
        $transfer_id = $this->transferService->createTransfer($dto);
 
        $sender->balance -= $dto->amount;
        $sender->save();
 
        $recipient->balance += $dto->amount;
        $recipient->save();
 
        $withdraw = TransactionDto::forWithdraw(
            AccountDto::fromModelToDto($sender),
            $dto->amount,
            $dto->reference,
            "Withdraw from account #{$sender->id}",
            $transfer_id
        );
        $withdraw->confirmed = true;
        $this->transactionService->createTransaction($withdraw);
 
        $deposit = TransactionDto::forDeposit(
            AccountDto::fromModelToDto($recipient),
            $dto->amount,
            $dto->reference,
            "Deposit to account #{$recipient->id}",
            $transfer_id
        );
        $deposit->confirmed = true;
        $this->transactionService->createTransaction($deposit);
 
        $this->transactionService->updateTransaction($withdraw->reference, $sender->balance);
        $this->transactionService->updateTransaction($deposit->reference, $recipient->balance);
    }
}
