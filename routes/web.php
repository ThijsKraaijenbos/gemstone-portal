<?php

use App\Http\Controllers\BlehController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('test',  BlehController::class)->names('test');
