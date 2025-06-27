<?php


namespace App\Services;

use App\Contracts\IAccountService;
use App\DTOs\AccountDto;
use App\DTOs\UserDto;
use App\Exceptions\AccountNumberWasSetException;
use App\Models\Account; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountService implements IAccountService{
    
    public function modelQuery():Builder{
        return Account::query();
    }

    public function createAccountNumber(UserDto $userDto) : Account{
         
        if($this->hasAccount($userDto)){
            throw new AccountNumberWasSetException('User already have an account');
        }
        
        return $this->modelQuery()->create(
            [
                'account_number' => substr( $userDto->phone ,-10),
                'user_id' => $userDto->id,
                'type' => 'SAVINGS',
                'currency' => 'EGP',
                'status' => 'ACTIVE'
            ]
        );
    }

    public function updateAccount(AccountDto $accountDto) {
        $account = $this->modelQuery()->where('account_number', $accountDto->account_number)->first();

        if (!$account) {
            throw new ModelNotFoundException('No account was found');
        }

        $account->update([
            'type' => $accountDto->type,
            'currency' => $accountDto->currency,
            'status' => $accountDto->status
        ]);
    }
 
    public function getAccountByNumber(string $account_number) : Account{
        return $this->modelQuery()->where('account_number', $account_number)->first();
    }

    public function getAccountByUserId(int $user_id) : Account{
        return $this->modelQuery()->where('user_id', $user_id)->first();
    } 

    public function hasAccount(UserDto $userDto) : bool{
        return $this->modelQuery()->where('user_id', $userDto->id)->exists();
    }
}