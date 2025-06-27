<?php
 
namespace App\Services;

use App\Contracts\ITransactionService;
use App\DTOs\AccountDto;
use App\DTOs\TransactionDto;
use App\Enums\TransactionCategory;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Str;
 

class TransactionService implements ITransactionService {

    public function modelQuery():Builder{
        return Transaction::query();
    }

    public function createTransaction(TransactionDto $transactionDto):Transaction  {
        $data = [];
        if($transactionDto->category == TransactionCategory::DEPOSIT->value) { 
            $data = TransactionDto::fromDepositToModel($transactionDto);
        }
        if($transactionDto->category == TransactionCategory::WITHDRAW->value) { 
            //
        }
        $transaction = $this->modelQuery()->create($data);
        return $transaction;
    }

    public function generateReference():string{
        return Str::upper('TF'.'/'.Carbon::now()->getTimestampMs().'/'.Str::random(4));
    } 

    public function getTransactionById(int $id):Transaction  {
        return $this->modelQuery()->where('id', $id)->first();
    }

    public function getTransactionByReference(string $reference):Transaction  {
        return $this->modelQuery()->where('reference', $reference)->first();
    }

    public function getTransactionByAccountNumber(string $account_number):Transaction  {
        return $this->modelQuery()->where('account_number', $account_number)->first();
    }

    public function getTransactionByUserId(string $user_id):Transaction  {
        return $this->modelQuery()->where('user_id', $user_id)->first();
    }

    public function transactionHistory(AccountDto $accountDto, Carbon $from, Carbon $to): Collection
    {
        return Transaction::query()
            ->where('account_id', $accountDto->id)  
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->orderByDesc('created_at')
            ->get();
    }

    public function updateTransaction(string $reference,int|float $balance) {
        $transaction = $this->getTransactionByReference($reference);
        $transaction->balance = $balance;
        $transaction->confirmed = true;
        $transaction->save();
    }
}
    
   