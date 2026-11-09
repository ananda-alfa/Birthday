<?php

use App\Http\Controllers\BirthdayGiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/birthday/novi', 'birthday.novi')
    ->name('birthday.novi');

Route::post('/birthday/novi/gift', [BirthdayGiftController::class, 'store'])
    ->middleware('throttle:20,1')
    ->name('birthday.novi.gift');
