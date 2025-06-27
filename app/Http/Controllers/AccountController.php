<?php

namespace App\Http\Controllers;

use App\DTOs\AccountDto;
use App\DTOs\UserDto;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(private readonly AccountService $accountService) {}

    public function createAccountNumber(Request $request){
        $userDto = UserDto::fromRequestToDto($request);
        $this->accountService->createAccountNumber($userDto); 
        return $this->sendSuccess([], 'Account number was created successfully');
    }

    public function updateccount(Request $request){
        $accountDto = AccountDto::fromRequestToDto($request);
        $this->accountService->updateAccount($accountDto); 
        return $this->sendSuccess([], 'Account was updated successfully');
    } 
}
