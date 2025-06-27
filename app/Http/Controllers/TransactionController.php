<?php

namespace App\Http\Controllers;

use App\DTOs\DepositDto;
use App\Http\Requests\DepositRequest;
use App\Services\AccountService; 

class TransactionController extends Controller
{
    public function __construct(private readonly AccountService $account_service){}

    public function deposite(DepositRequest $request){
        $depositDto = DepositDto::fromRequestToDto($request);
        $this->account_service->deposit($depositDto);
        return $this->sendSuccess([],"Deposit was processed successfully");
    }   
}
