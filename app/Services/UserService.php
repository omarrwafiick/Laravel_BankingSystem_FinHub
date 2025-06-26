<?php

namespace App\Services;

use App\DTOs\UserDto;
use App\Models\User;

class UserService{
    public function createUser(UserDto $dto): User    
    {
        return User::query()->create([
            'name' - $dto->name,
            'email' - $dto->email,
            'password' - $dto->password,
            'phone_number' - $dto->phone,
        ]);
    }
}


