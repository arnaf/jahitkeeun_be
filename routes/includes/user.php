<?php

use Illuminate\Support\Facades\Route;

Route::get('/user', 'UserController@index');
Route::get('/user/{id}', 'UserController@show');
Route::post('/user', 'UserController@store');
Route::post('/user/{id}', 'UserController@update');
Route::delete('/user/{id}', 'UserController@destroy');


Route::post('/user/update/profile/{id}', 'UserController@profileUpdateByID');
Route::post('/user/update/role/{id}', 'UserController@roleUpdateByID');
Route::post('/user/update/password/{id}', 'UserController@passwordUpdateByID');
