<?php

use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/../src/BoundedContext/User/Infrastructure/routes/web.php';
require __DIR__.'/../src/BoundedContext/Auth/Infrastructure/routes/web.php';
