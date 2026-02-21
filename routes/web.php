<?php

use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function(){
    Route::get('users', [UsersController::class, 'getUser']);
});
