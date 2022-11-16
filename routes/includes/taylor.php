<?php

use Illuminate\Support\Facades\Route;

Route::get('/taylor', 'TaylorController@getAllTaylor');
Route::get('/taylor/{keyword}', 'TaylorController@getTaylorByName');
