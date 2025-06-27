<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnBoardingController;
  
Route::prefix("auth")->group(function () { 

    Route::post("register", [AuthController::class,"register"]);
    Route::post("login", [AuthController::class,"login"]);

    Route::middleware("auth:sanctum")->group(function () {
       Route::get('user', [AuthController::class,"user"]);
       Route::get(uri: 'logout', [AuthController::class,"logout"]);        
    });
    
}); 

Route::middleware("auth:sanctum")->group(function () { 
   Route::post(uri: 'onboarding/pin', [OnBoardingController::class,"createPinToUser"]);
   Route::post(uri: 'onboarding/pin/validate', [OnBoardingController::class,"validatePin"]);   
   Route::post(uri: 'account/number', [AccountController::class,"createAccountNumber"]); 
   Route::put(uri: 'account', [AccountController::class,"updateccount"]);  
});