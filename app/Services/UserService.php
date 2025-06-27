<?php

namespace App\Services;

use App\Contracts\IUserService;
use App\DTOs\UserDto;
use App\Exceptions\InvalidPinLengthException;
use App\Exceptions\PinNotSetException;
use App\Exceptions\PinWasSetException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash; 

class UserService implements IUserService
{
    public function createUser(UserDto $dto): Builder | Model    
    {
        $role = Role::where('name', 'CUSTOMER')->first();
        return User::query()->create([
            'name' - $dto->name,
            'email' - $dto->email,
            'password' - $dto->password,
            'phone_number' - $dto->phone,
            'role_id' => $role->id
        ]);
    }

    public function getUserById(int $id): Builder | Model{
        $user = User::query()->where('id',$id)->first();
        if(!$user){
            throw new ModelNotFoundException('User was not found using this id :'. $id);
        }
        return $user;
    }

    public function createPin(User $user, string $pin): void{
        if($this->hasPin($user)){
            throw new PinWasSetException('Pin was set already to this user');
        }
        if(strlen($pin) != 4){
            throw new InvalidPinLengthException('Invalid pin length must be of 4 chars');
        }
        $user->pin = Hash::make($pin);
        $user->save();
    }

    public function validatePin(int $userId, string $pin): bool{
        $user = $this->getUserById($userId); 
        if(!$this->hasPin($user)){
            throw new PinNotSetException('Pin was not set to this user');
        }
        return Hash::check($pin, $user->pin);
    }

    public function hasPin(Model $user): bool{
        return $user->pin != null;
    }
}


