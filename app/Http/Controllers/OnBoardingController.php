<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class OnBoardingController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    function createPinToUser(Request $request){
        $this->validate($request, ['pin'=> ['required','string', 'min:4', 'max:4']]); 
        $user = $request->user();
        $this->userService->createPin($user, $request->input('pin'));
        return $this->sendSuccess('Pin was set successfully');
    }

    function validatePin(Request $request){ 
        $user = $request->user();
        $this->userService->validatePin($user->id, $request->input('pin'));
        return $this->sendSuccess('Pin was validated successfully');
    }
}
