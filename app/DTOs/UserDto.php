<?php

namespace App\DTOs;

use App\Http\Requests\RegisterationRequest;
use App\Contracts\DtoInterface; 
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest; 

class UserDto implements DtoInterface
{
    public string $name;
    public string $email;
    public string $password;
    public string $phone;
    public ?string $pin = null;
    public ?Carbon $created_at = null;
    public ?Carbon $updated_at = null;
 
    public static function fromRequestToDto(FormRequest $request): self
    {
        $dto = new self();
        $dto->name = $request->input("name");
        $dto->email = $request->input("email");
        $dto->password = $request->input("password");
        $dto->phone = $request->input("phone"); 
        return $dto;
    }
 
    public static function fromModelToDto(Model $model): self
    {
        $dto = new self();
        $dto->name = $model->name;
        $dto->email = $model->email; 
        $dto->phone = $model->phone;
        $dto->pin = $model->pin;
        $dto->created_at = $model->created_at instanceof Carbon ? $model->created_at : new Carbon($model->created_at);
        $dto->updated_at = $model->updated_at instanceof Carbon ? $model->updated_at : new Carbon($model->updated_at);
        return $dto;
    }
 
    public function toArray(Model $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone_number,
            'pin' => $model->pin,
            'created_at' => optional($model->created_at)->toDateTimeString(),
            'updated_at' => optional($model->updated_at)->toDateTimeString(),
        ];
    }
}