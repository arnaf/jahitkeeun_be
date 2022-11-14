<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/migrate', function() {
    Artisan::call('migrate');
    return 'Configuration migrate! <br> Configuration cached successfully!';
});



Route::get('/p', function() {
    Artisan::call('passport::install');
    return 'Configuration p! <br> Configuration cached successfully!';
});

