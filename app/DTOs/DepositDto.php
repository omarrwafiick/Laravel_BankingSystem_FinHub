<?php

namespace App\DTOs;
 
use App\Contracts\DtoInterface; 
use App\Enums\TransactionCategory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest; 

class DepositDto implements DtoInterface
{
    public int $id;
    public string $account_number;
    public int|float $amount;
    public string|null $description;
    public int $transfer_id;
    public string $category; 
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
 
    public static function fromRequestToDto(FormRequest $request): self
    {
        $dto = new self(); 
        $dto->account_number = $request->input("account_number");
        $dto->amount = $request->input("amount");
        $dto->description = $request->input("description");
        $dto->transfer_id = $request->input("transfer_id");
        $dto->category = TransactionCategory::DEPOSIT->value;  
        return $dto;
    }
 
    public static function fromModelToDto(Model $model): self
    {
        $dto = new self();
        $dto->id = $model->id;
        $dto->account_number = $model->account_number;
        $dto->amount = $model->amount; 
        $dto->description = $model->description;
        $dto->transfer_id = $model->transfer_id;
        $dto->category = $model->category;
        $dto->created_at = $model->created_at instanceof Carbon ? $model->created_at : new Carbon($model->created_at);
        $dto->updated_at = $model->updated_at instanceof Carbon ? $model->updated_at : new Carbon($model->updated_at);
        return $dto;
    }
 
    public function toArray(Model $model): array
    {
        return [
            'id' => $model->id,
            'account_number' => $model->account_number,
            'description' => $model->description,
            'category' => $model->category,
            'amount' => $model->amount,
            'transfer_id' => $model->transfer_id,
            'created_at' => optional($model->created_at)->toDateTimeString(),
            'updated_at' => optional($model->updated_at)->toDateTimeString(),
        ];
    }

}