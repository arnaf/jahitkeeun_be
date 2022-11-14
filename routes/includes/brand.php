<?php

use Illuminate\Support\Facades\Route;

Route::get('/brand', 'BrandController@index');
Route::get('/brand/{id}', 'BrandController@show');
Route::post('/brand', 'BrandController@store');
Route::post('/brand/{id}', 'BrandController@update');
Route::delete('/brand/{id}', 'BrandController@destroy');

Route::group(
    [
        'prefix'    => 'brand',
    ], function () {
        Route::post('/register', 'BrandController@register');

    });
