<?php

use Illuminate\Support\Facades\Route;

Route::get('/datamaster/client', 'MasterClientController@index');
Route::get('/datamaster/client/{id}', 'MasterClientController@show');
Route::post('/datamaster/client/create', 'MasterClientController@create');
Route::post('/datamaster/client/update/{id}', 'MasterClientController@update');
Route::delete('/datamaster/client/delete/{id}', 'MasterClientController@delete');

Route::get('/datamaster/convection', 'MasterConvectionController@index');
Route::get('/datamaster/convection/{id}', 'MasterConvectionController@show');
Route::post('/datamaster/convection/create', 'MasterConvectionController@create');
Route::post('/datamaster/convection/update/{id}', 'MasterConvectionController@update');
Route::delete('/datamaster/convection/delete/{id}', 'MasterConvectionController@delete');

Route::get('/datamaster/taylor', 'MasterTaylorController@index');
Route::get('/datamaster/taylor/{id}', 'MasterTaylorController@show');
Route::post('/datamaster/taylor/create', 'MasterTaylorController@create');
Route::post('/datamaster/taylor/update/{id}', 'MasterTaylorController@update');
Route::delete('/datamaster/taylor/delete/{id}', 'MasterTaylorController@delete');



