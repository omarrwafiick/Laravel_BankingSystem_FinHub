<?php

namespace App\Http\Controllers;

use App\DTOs\AuditLogDto;
use App\Enums\AuditAction;
use App\Http\Controllers\Controller;
use App\DTOs\UserDto;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterationRequest;  
use App\Services\AuditLogService;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{ 
    public function __construct(private readonly UserService $userService, private readonly AuditLogService $auditLogService) {}
    
    public function register(RegisterationRequest $request){
        $userDto = UserDto::fromRequestToDto($request);
        $user = $this->userService->createUser($userDto);
        return $this->sendSuccess(['user'=> $user], "Successfull Registration");
    }

    public function login(LoginRequest $request){
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)){
            return $this->sendError('the provided credentials are incorrect.', 400);
        } 
        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $auditDto = AuditLogDto::dtoObj(AuditAction::LOGIN->value, $user->id);
        $this->auditLogService->logAction($auditDto);
        return $this->sendSuccess(['user' => $user, 'message' => 'logged in successfully', 'token' => $token],200);
    }

    public function user(Request $request){ 
        $user = $request->user(); 
        return $this->sendSuccess(['user'=> $user, 'message' => 'Authenticated user'],200);
    }
    
    public function logout(Request $request){ 
        $user = $request->user(); 
        $user->tokens()->delete();
        $auditDto = AuditLogDto::dtoObj(AuditAction::LOGOUT->value, $user->id);
        $this->auditLogService->logAction($auditDto);
        return $this->sendSuccess(['message' => 'Logged out successfully'],200);
    }
}
