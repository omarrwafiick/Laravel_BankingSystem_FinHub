<?php

namespace App\DTOs;
 
use App\Contracts\DtoInterface; 
use App\Enums\TransactionCategory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest; 

class TransactionDto implements DtoInterface
{
    public int $id;
    public string $user_id;
    public string $reference;
    public int $transfer_id;
    public int $account_id;  
    public int|float $amount;
    public int|float $balance; 
    public string $category;
    public bool $confirmed;
    public string|null $description;
    public string|null $meta;
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
 
    public static function fromRequestToDto(FormRequest $request): self
    {
        $dto = new self(); 
        $dto->user_id = $request->input("user_id");
        $dto->reference = $request->input("reference");
        $dto->transfer_id = $request->input("transfer_id");
        $dto->account_id = $request->input("account_id");  
        $dto->amount = $request->input("amount");  
        $dto->balance = $request->input("balance"); 
        $dto->category = $request->input("category");  
        $dto->confirmed = $request->input("confirmed");  
        $dto->description = $request->input("description");  
        $dto->meta = $request->input("meta");  
        return $dto;
    }
 
    public static function fromModelToDto(Model $model): self
    {
        $dto = new self();
        $dto->id = $model->id;   
        $dto->user_id =  $model->user_id;
        $dto->reference = $model->reference;
        $dto->transfer_id = $model->transfer_id;
        $dto->account_id = $model->account_id;  
        $dto->amount = $model->amount;  
        $dto->balance = $model->balance;  
        $dto->category = $model->category;  
        $dto->confirmed = $model->confirmed;  
        $dto->description = $model->description;  
        $dto->meta = $model->meta;  
        $dto->created_at = $model->created_at instanceof Carbon ? $model->created_at : new Carbon($model->created_at);
        $dto->updated_at = $model->updated_at instanceof Carbon ? $model->updated_at : new Carbon($model->updated_at);
        return $dto;
    }
 
    public function toArray(Model $model): array
    {
        return [
            'id' => $model->id,
            'user_id' => $model->user_id,
            'reference' => $model->reference,
            'transfer_id' => $model->transfer_id,
            'account_id' => $model->account_id,
            'amount' => $model->id,
            'balance' => $model->balance,
            'category' => $model->category,
            'confirmed' => $model->confirmed,
            'description' => $model->description,
            'meta' => $model->meta, 
            'created_at' => optional($model->created_at)->toDateTimeString(),
            'updated_at' => optional($model->updated_at)->toDateTimeString(),
        ];
    }
    
    public function forDeposit(AccountDto $accountDto, int|float $amount, string $reference, string|null $description, int $transfer_id)
    { 
        $dto = new self();
        $dto->user_id = $accountDto->user_id;
        $dto->reference = $reference;
        $dto->transfer_id = $transfer_id;
        $dto->account_id = $accountDto->id;
        $dto->amount = $amount;
        $dto->category = TransactionCategory::DEPOSIT->value;
        $dto->description =  $description;
        return $dto;
    }

    public function forWithdraw(AccountDto $accountDto, int|float $amount, string $reference, string|null $description, int $transfer_id)
    { 
        $dto = new self();
        $dto->user_id = $accountDto->user_id;
        $dto->reference = $reference;
        $dto->transfer_id = $transfer_id;
        $dto->account_id = $accountDto->id;
        $dto->amount = $amount;
        $dto->category = TransactionCategory::WITHDRAW->value;
        $dto->description =  $description;
        return $dto;
    }
 
    public static function fromDepositToModel(TransactionDto $transactionDto)
    { 
        return [
            'id' => $transactionDto->id,
            'user_id' => $transactionDto->user_id,
            'reference' => $transactionDto->reference,
            'transfer_id' => $transactionDto->transfer_id,
            'account_id' => $transactionDto->account_id,
            'amount' => $transactionDto->amount,
            'balance' => $transactionDto->balance,
            'category' => $transactionDto->category,
            'confirmed' => $transactionDto->confirmed,
            'description' => $transactionDto->description,
            'meta' => $transactionDto->meta, 
            'created_at' => optional( $transactionDto->created_at)->toDateTimeString(),
            'updated_at' => optional($transactionDto->updated_at)->toDateTimeString(),
        ];
    } 

    public static function fromWithdrawToModel(TransactionDto $transactionDto)
    { 
        return [
            'id' => $transactionDto->id,
            'user_id' => $transactionDto->user_id,
            'reference' => $transactionDto->reference,
            'transfer_id' => $transactionDto->transfer_id,
            'account_id' => $transactionDto->account_id,
            'amount' => $transactionDto->amount,
            'balance' => $transactionDto->balance,
            'category' => $transactionDto->category,
            'confirmed' => $transactionDto->confirmed,
            'description' => $transactionDto->description,
            'meta' => $transactionDto->meta, 
            'created_at' => optional( $transactionDto->created_at)->toDateTimeString(),
            'updated_at' => optional($transactionDto->updated_at)->toDateTimeString(),
        ];
    } 
}