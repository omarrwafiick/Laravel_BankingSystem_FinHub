<?php

namespace App\Http\Controllers;

use App\DTOs\DepositDto;
use App\DTOs\TransferDto;
use App\DTOs\WithDrawDto;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\WithDrawRequest;
use App\Services\AccountService; 

class TransactionController extends Controller
{
    public function __construct(private readonly AccountService $account_service){}

    public function deposite(DepositRequest $request){
        $depositDto = DepositDto::fromRequestToDto($request);
        $transactionDto = $this->account_service->deposit($depositDto);
        return $this->sendSuccess(['transaction_reference'=> $transactionDto->reference],"Deposit was processed successfully");
    }   

    public function withdraw(WithDrawRequest $request){
        $withDrawDto = WithDrawDto::fromRequestToDto($request);
        $transactionDto = $this->account_service->withdraw($withDrawDto);
        return $this->sendSuccess(['transaction_reference'=> $transactionDto->reference],"WithDraw was processed successfully");
    }   

    public function transfer(TransferRequest $request){
        $transferDto = TransferDto::fromRequestToDto($request);
        $this->account_service->transfer($transferDto);
        return $this->sendSuccess([],"Transfer was processed successfully");
    }   
}
