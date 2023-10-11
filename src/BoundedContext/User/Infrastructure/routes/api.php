<?php

use Illuminate\Support\Facades\Route;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\API\CreateUserController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\API\DeleteUserController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\API\GetUserController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\API\SearcUsersController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\API\UpdateUserController;

Route::post('user', CreateUserController::class);
Route::delete('user/{id}', DeleteUserController::class);
Route::get('user', SearcUsersController::class);
Route::get('user/{id}', GetUserController::class);
Route::put('user/{id}', UpdateUserController::class);