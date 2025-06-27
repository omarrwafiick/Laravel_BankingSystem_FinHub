<?php

namespace App\DTOs;
 
use App\Contracts\DtoInterface; 
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest; 

class AccountDto implements DtoInterface
{
    public string $id;
    public string $account_number;
    public string $status;
    public string $currency;
    public string $type; 
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
 
    public static function fromRequestToDto(FormRequest $request): self
    {
        $dto = new self(); 
        $dto->account_number = $request->input("account_number");
        $dto->type = $request->input("type");
        $dto->currency = $request->input("currency");
        $dto->status = $request->input("status");  
        return $dto;
    }
 
    public static function fromModelToDto(Model $model): self
    {
        $dto = new self();
        $dto->id = $model->id;
        $dto->account_number = $model->account_number;
        $dto->currency = $model->currency; 
        $dto->status = $model->status;
        $dto->type = $model->type;
        $dto->created_at = $model->created_at instanceof Carbon ? $model->created_at : new Carbon($model->created_at);
        $dto->updated_at = $model->updated_at instanceof Carbon ? $model->updated_at : new Carbon($model->updated_at);
        return $dto;
    }
 
    public function toArray(Model $model): array
    {
        return [
            'id' => $model->id,
            'account_number' => $model->account_number,
            'currency' => $model->currency,
            'status' => $model->status,
            'type' => $model->type,
            'created_at' => optional($model->created_at)->toDateTimeString(),
            'updated_at' => optional($model->updated_at)->toDateTimeString(),
        ];
    }
}