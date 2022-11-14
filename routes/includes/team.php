<?php

use Illuminate\Support\Facades\Route;

Route::get('/team', 'teamController@index');
Route::get('/team/{id}', 'teamController@show');
Route::post('/team', 'teamController@store');
Route::post('/team/{id}', 'teamController@update');
Route::delete('/team/{id}', 'teamController@destroy');

Route::group(
    [
        'prefix'    => 'team',
    ], function () {
        Route::post('/register', 'teamController@register');

    });
