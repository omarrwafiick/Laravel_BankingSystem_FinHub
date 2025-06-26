<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DTOs\UserDto;
use App\Http\Requests\RegisterationRequest;  
use Illuminate\Http\Request;
use App\Services\UserService;

class AuthController extends Controller
{ 
    public function __construct(private readonly UserService $userService) {

    }
    public function register(RegisterationRequest $request){
        $userDto = UserDto::fromRequestToDto($request);
        $user = $this->userService->createUser($userDto);
        return $this->sendSuccess(['user'=> $user], "Successfull Registration");
    }

    public function login(Request $request){

    }
}
