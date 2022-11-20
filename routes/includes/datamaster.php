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

Route::get('/datamaster/address', 'MasterAddressController@index');
Route::get('/datamaster/address/{id}', 'MasterAddressController@show');
Route::post('/datamaster/address/create', 'MasterAddressController@create');
Route::post('/datamaster/address/update/{id}', 'MasterAddressController@update');
Route::delete('/datamaster/address/delete/{id}', 'MasterAddressController@delete');

Route::get('/datamaster/delivery', 'MasterDeliveryController@index');
Route::get('/datamaster/delivery/{id}', 'MasterDeliveryController@show');
Route::post('/datamaster/delivery/create', 'MasterDeliveryController@create');
Route::post('/datamaster/delivery/update/{id}', 'MasterDeliveryController@update');
Route::delete('/datamaster/delivery/delete/{id}', 'MasterDeliveryController@delete');

Route::get('/datamaster/service', 'MasterServiceController@index');
Route::get('/datamaster/service/{id}', 'MasterServiceController@show');
Route::post('/datamaster/service/create', 'MasterServiceController@create');
Route::post('/datamaster/service/update/{id}', 'MasterServiceController@update');
Route::delete('/datamaster/service/delete/{id}', 'MasterServiceController@delete');

Route::get('/datamaster/portofolio', 'MasterPortofolioController@index');
Route::get('/datamaster/portofolio/{id}', 'MasterPortofolioController@showPortoByPorto');
Route::get('/datamaster/taylorportofolio/{id}', 'MasterPortofolioController@showPortoByTaylor');
Route::post('/datamaster/portofolio/create', 'MasterPortofolioController@create');
Route::post('/datamaster/portofolio/update/{id}', 'MasterPortofolioController@update');
Route::delete('/datamaster/portofolio/delete/{id}', 'MasterPortofolioController@delete');

Route::get('/datamaster/maklun', 'MasterMaklunController@index');
Route::get('/datamaster/maklun/{id}', 'MasterMaklunController@show');
Route::post('/datamaster/maklun/create', 'MasterMaklunController@create');
Route::post('/datamaster/maklun/update/{id}', 'MasterMaklunController@update');
Route::delete('/datamaster/maklun/delete/{id}', 'MasterMaklunController@delete');





