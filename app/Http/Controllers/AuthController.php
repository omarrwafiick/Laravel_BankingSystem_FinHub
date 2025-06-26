<?php

namespace App\Http\Controllers;

use App\DTOs\UserDto;
use App\Http\Requests\RegisterationRequest; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Services\UserService;

class AuthController extends Controller
{ 
    public function __construct(private readonly UserService $userService) {

    }
    public function register(RegisterationRequest $request){
        $validation = $request->validated();
        $userDto = UserDto::fromRequestToDto($request);
        $user = $this->userService->createUser($userDto);
        return response()->json(['user'=> $user, 'success'=> true]);
    }

    public function login(Request $request){

    }
}
