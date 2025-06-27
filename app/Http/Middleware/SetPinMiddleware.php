<?php

namespace App\Http\Middleware;

use App\Exceptions\PinNotSetException;
use App\Services\UserService;
use App\Traits\ApiResponseTraits;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPinMiddleware
{
    use ApiResponseTraits;
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $userService = new UserService();
        $hasPin = $userService->hasPin($user);
        if(!$hasPin){
            return $this->sendError('Pin was not sent',401);
        }
        $validatePin = $userService->validatePin($user->id,$user->pin);
        if(!$validatePin){ 
            return $this->sendError('Invalid pin',403);
        }
        return $next($request);
    }
}
