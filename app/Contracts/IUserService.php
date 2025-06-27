<?php

namespace App\Contracts;

use App\DTOs\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface IUserService{
    public function createUser(UserDto $dto): Builder | Model;
    public function createPin(User $user, string $pin): void;
    public function getUserById(int $id): Builder | Model; 
    public function validatePin(int $userId, string $pin): bool;
    public function hasPin(User $user): bool; 
}