<?php

namespace App\DTOs;
 
use App\Contracts\DtoInterface; 
use App\Enums\TransferStatus;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest; 

class TransferDto implements DtoInterface
{
    public int $id; 
    public int $sender_account_id;
    public int $recipient_account_id;
    public int|float $amount;
    public string $reference; 
    public string $status; 
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
 
    public static function fromRequestToDto(FormRequest $request): self
    {
        $dto = new self(); 
        $dto->sender_account_id = $request->input("sender_account_id");
        $dto->recipient_account_id = $request->input("recipient_account_id");
        $dto->amount = $request->input("amount");
        $dto->status = TransferStatus::PENDING->value;  
        return $dto;
    }
 
    public static function fromModelToDto(Model $model): self
    {
        $dto = new self();
        $dto->id = $model->id;
        $dto->sender_account_id = $model->sender_account_id;
        $dto->recipient_account_id = $model->recipient_account_id; 
        $dto->amount = $model->amount;
        $dto->status = $model->status;
        $dto->reference = $model->reference;
        $dto->created_at = $model->created_at instanceof Carbon ? $model->created_at : new Carbon($model->created_at);
        $dto->updated_at = $model->updated_at instanceof Carbon ? $model->updated_at : new Carbon($model->updated_at);
        return $dto;
    }
 
    public function toArray(Model $model): array
    {
        return [
            'id' => $model->id,
            'sender_account_id' => $model->sender_account_id,
            'recipient_account_id' => $model->recipient_account_id,
            'amount' => $model->amount,
            'status' => $model->status,
            'reference' => $model->reference,
            'created_at' => optional($model->created_at)->toDateTimeString(),
            'updated_at' => optional($model->updated_at)->toDateTimeString(),
        ];
    }
}