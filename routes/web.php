<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirportController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/json', [AirportController::class, 'json']);
Route::resource('/airports', AirportController::class);


