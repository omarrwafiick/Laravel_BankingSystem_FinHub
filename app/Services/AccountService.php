<?php
 
namespace App\Services;

use App\Contracts\IAccountService;
use App\DTOs\AccountDto;
use App\DTOs\DepositDto;
use App\DTOs\TransactionDto;
use App\DTOs\UserDto; 
use App\DTOs\WithDrawDto;
use App\Enums\AccountStatus;
use App\Events\DepositEvent;
use App\Events\WithDrawEvent;
use App\Exceptions\AccountNumberWasSetException;
use App\Exceptions\InsufficientFundsException;
use App\Models\Account; 
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountService implements IAccountService{
    public function __construct(private TransactionService $transactionService){}
   
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

    public function deposit(DepositDto $depositDto ): TransactionDto {
        $minimum_deposit = 500;
        if ($depositDto->amount < $minimum_deposit){
            throw new InsufficientFundsException('deposite amount should be greater than ' . $minimum_deposit);
        }

        try{
            DB::beginTransaction();

            $accountQuery = $this->modelQuery()->where('account_number', $depositDto->account_number);
            $this->accountExists($accountQuery);

            $lockedAccount = $accountQuery->lockForUpdate()->first();
            $accountDto = AccountDto::fromModelToDto($lockedAccount);

            $transactionDto = new TransactionDto();
            $reference = $this->transactionService->generateReference(); 
            $transactionDto = $transactionDto->forDeposit($accountDto, $depositDto->amount, $reference, $depositDto->description, $depositDto->transfer_id);
            
            event(new DepositEvent($transactionDto, $accountDto, $lockedAccount));
            DB::commit();
            return $transactionDto;
        }
        catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function withdraw(WithDrawDto $withDrawDto): TransactionDto { 
        try{
            DB::beginTransaction();

            $accountQuery = $this->modelQuery()->where('account_number', $withDrawDto->account_number);
            $this->accountExists($accountQuery);
 
            $lockedAccount = $accountQuery->lockForUpdate()->first();

            $validateAccount = $this->canWithdraw($withDrawDto->amount, $lockedAccount);
            if (!$validateAccount){
                throw new InsufficientFundsException('Account is blocked or balance amount is insufficient');
            } 

            $accountDto = AccountDto::fromModelToDto($lockedAccount);

            $transactionDto = new TransactionDto();
            $reference = $this->transactionService->generateReference(); 
            $transactionDto = $transactionDto->forWithdraw($accountDto, $withDrawDto->amount, $reference, $withDrawDto->description, $withDrawDto->transfer_id);
            
            event(new WithDrawEvent($transactionDto, $accountDto, $lockedAccount));
            DB::commit();
            return $transactionDto;
        }
        catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function canWithdraw(int|float $amount, Account $account): bool {
        $maximum_withdraw = $account->balance; 
        if($amount > $maximum_withdraw || $account->status == AccountStatus::FROZEN->value || $account->status == AccountStatus::CLOSED->value) {
            return false;
        }
        return true;
    }

    public function accountExists(Builder $query) {
        if(!$query->exists()){
            throw new ModelNotFoundException('Invalid account number');
        } 
    } 
}