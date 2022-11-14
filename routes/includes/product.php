<?php

use Illuminate\Support\Facades\Route;

Route::get('/product', 'ProductController@index');
Route::get('/product/{id}', 'ProductController@show');
Route::post('/product', 'ProductController@store');
Route::post('/product/{id}', 'ProductController@update');
Route::delete('/product/{id}', 'ProductController@destroy');

Route::group(
    [
        'prefix'    => 'product',
    ], function () {
        Route::post('/register', 'ProductController@register');

    });
