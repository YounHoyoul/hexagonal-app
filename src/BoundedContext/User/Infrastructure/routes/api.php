<?php

use Illuminate\Support\Facades\Route;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\CreateUserController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\DeleteUserController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\GetUserController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\SearcUsersController;
use Src\BoundedContext\User\Infrastructure\Http\Controllers\UpdateUserController;

Route::post('user', CreateUserController::class);
Route::delete('user/{id}', DeleteUserController::class);
Route::get('user', SearcUsersController::class);
Route::get('user/{id}', GetUserController::class);
Route::put('user/{id}', UpdateUserController::class);
