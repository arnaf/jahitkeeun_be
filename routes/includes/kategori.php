<?php

use Illuminate\Support\Facades\Route;

Route::get('/kategori', 'kategoriController@index');
Route::get('/kategori/{id}', 'kategoriController@show');
Route::post('/kategori', 'kategoriController@store');
Route::post('/kategori/{id}', 'kategoriController@update');
Route::delete('/kategori/{id}', 'kategoriController@destroy');

Route::group(
    [
        'prefix'    => 'kategori',
    ], function () {
        Route::post('/register', 'kategoriController@register');

    });
