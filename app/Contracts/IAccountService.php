<?php 

namespace App\Contracts;

use App\DTOs\AccountDto;
use App\DTOs\UserDto;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface IAccountService{
    public function modelQuery():Builder;
    public function createAccountNumber(UserDto $userDto) : Account;
    public function updateAccount(AccountDto $accountDto);
    public function getAccountByNumber(string $account_number) : Account;
    public function getAccountByUserId(int $user_id) : Account; 
    public function hasAccount(UserDto $userDto) : bool;
}