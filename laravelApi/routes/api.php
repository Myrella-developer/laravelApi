<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthenticationController;

//Open Routes
Route::post("register", [AuthenticationController::class, "register"]);
Route::post("login", [AuthenticationController::class, "login"]);

//Protected Routes
Route::group([
    "middleware" => ["auth:api"]
], function(){

    Route::get("profile", [AuthenticationController::class, "profile"]);
    Route::get("logout", [AuthenticationController::class, "logout"]);
});

// Route::get('/user', function(Request $request) {
//     return $request->user();
// })->middleware('auth:api');

