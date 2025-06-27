<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OnBoardingController;
use App\Http\Controllers\TransactionController;
  
Route::prefix("auth")->group(function () { 

    Route::post("register", [AuthController::class,"register"]);
    Route::post("login", [AuthController::class,"login"]);

    Route::middleware("auth:sanctum")->group(function () {
       Route::get('user', [AuthController::class,"user"]);
       Route::get(uri: 'logout', [AuthController::class,"logout"]);        
    });
    
}); 

Route::middleware(["auth:sanctum", 'throttle:30,1'])->group(function () {

   Route::prefix("onboarding")->group(function () {
      Route::post(uri: 'pin', [OnBoardingController::class,"createPinToUser"]);
      Route::post(uri: 'pin/validate', [OnBoardingController::class,"validatePin"]);
   }); 

   Route::prefix("account")->group(function () {
      Route::post(uri: 'number', [AccountController::class,"createAccountNumber"]); 
      Route::put(uri: '', [AccountController::class,"updateccount"]);   
   });   

   Route::middleware("has.pin")->group(function(){
      Route::prefix("transaction")->group(function () {
         Route::post(uri: 'deposit', [TransactionController::class,"deposite"]);  
         Route::post(uri: 'withdraw', [TransactionController::class,"withdraw"]);  
      });  
   });

});