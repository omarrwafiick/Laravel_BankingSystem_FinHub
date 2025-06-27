<?php

namespace App\Contracts;

use App\DTOs\AccountDto;
use App\DTOs\TransactionDto;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface ITransactionService{
    public function modelQuery():Builder;
    public function createTransaction(TransactionDto $transactionDto) : Transaction;
    public function generateTransactionReference():string; 
    public function generateTransferReference():string;
    public function getTransactionById(int $id):Transaction;
    public function getTransactionByReference(string $reference):Transaction ;
    public function getTransactionByAccountNumber(string $account_number):Transaction;
    public function getTransactionByUserId(string $user_id):Transaction ;
    public function transactionHistory(int $account_number, string $category, Carbon $from, Carbon $to):Collection;
    public function updateTransaction(string $reference, int|float $balance);
}