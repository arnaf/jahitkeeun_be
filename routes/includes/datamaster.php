<?php

use Illuminate\Support\Facades\Route;

Route::get('/datamaster/client', 'MasterClientController@index');
Route::get('/datamaster/client/userID/{id}', 'MasterClientController@showByUserId');
Route::get('/datamaster/client/clientID/{id}', 'MasterClientController@showByClientId');
Route::post('/datamaster/client/create', 'MasterClientController@create');
Route::post('/datamaster/client/updateByUserId/{id}', 'MasterClientController@updateByUserId');
Route::delete('/datamaster/client/deleteByUserId/{id}', 'MasterClientController@deleteByUserId');

Route::get('/datamaster/convection', 'MasterConvectionController@index');
Route::get('/datamaster/convection/userID/{id}', 'MasterConvectionController@showByUserId');
Route::get('/datamaster/convection/convectionID/{id}', 'MasterConvectionController@showByConvectionId');
Route::post('/datamaster/convection/create', 'MasterConvectionController@create');
Route::post('/datamaster/convection/updateByUserId/{id}', 'MasterConvectionController@updateByUserId');
Route::delete('/datamaster/convection/deleteByUserId/{id}', 'MasterConvectionController@deleteByUserId');

Route::get('/datamaster/taylor', 'MasterTaylorController@index');
Route::get('/datamaster/taylor/userID/{id}', 'MasterTaylorController@showByUserId');
Route::get('/datamaster/taylor/taylorID/{id}', 'MasterTaylorController@showByTaylorId');
Route::post('/datamaster/taylor/create', 'MasterTaylorController@create');
Route::post('/datamaster/taylor/updateByUserId/{id}', 'MasterTaylorController@updateByUserId');
Route::delete('/datamaster/taylor/deleteByUserId/{id}', 'MasterTaylorController@deleteByUserId');

Route::get('/datamaster/address', 'MasterAddressController@index');
Route::get('/datamaster/address/userID/{id}', 'MasterAddressController@showByUserId');
Route::get('/datamaster/address/addressID/{id}', 'MasterAddressController@showByAddressId');
Route::post('/datamaster/address/create', 'MasterAddressController@create');
Route::post('/datamaster/address/updateByAddressId/{id}', 'MasterAddressController@updateByAddressId');
Route::delete('/datamaster/address/deleteByAddressId/{id}', 'MasterAddressController@deleteByAddressId');

Route::get('/datamaster/delivery', 'MasterDeliveryController@index');
Route::get('/datamaster/delivery/{id}', 'MasterDeliveryController@show');
Route::post('/datamaster/delivery/create', 'MasterDeliveryController@create');
Route::post('/datamaster/delivery/update/{id}', 'MasterDeliveryController@update');
Route::delete('/datamaster/delivery/delete/{id}', 'MasterDeliveryController@delete');

Route::get('/datamaster/service', 'MasterServiceController@index');
Route::get('/datamaster/service/serviceID/{id}', 'MasterServiceController@showServicesByServiceId');
Route::get('/datamaster/service/taylorID/{id}', 'MasterServiceController@showServicesByTaylorId');
Route::post('/datamaster/service/create', 'MasterServiceController@create');
Route::post('/datamaster/service/update/{id}', 'MasterServiceController@update');
Route::delete('/datamaster/service/delete/{id}', 'MasterServiceController@delete');

Route::get('/datamaster/portofolio', 'MasterPortofolioController@index');
Route::get('/datamaster/portofolio/portoID/{id}', 'MasterPortofolioController@showPortoByPorto');
Route::get('/datamaster/portofolio/taylorID/{id}', 'MasterPortofolioController@showPortoByTaylor');
Route::post('/datamaster/portofolio/create', 'MasterPortofolioController@create');
Route::post('/datamaster/portofolio/update/{id}', 'MasterPortofolioController@update');
Route::delete('/datamaster/portofolio/delete/{id}', 'MasterPortofolioController@deleteByPortoId');

Route::get('/datamaster/maklun', 'MasterMaklunController@index');
Route::get('/datamaster/maklun/userID/{id}', 'MasterMaklunController@showByUserID');
Route::get('/datamaster/maklun/maklunID/{id}', 'MasterMaklunController@showByMaklunId');
Route::post('/datamaster/maklun/create', 'MasterMaklunController@create');
Route::post('/datamaster/maklun/update/{id}', 'MasterMaklunController@update');
Route::delete('/datamaster/maklun/delete/{id}', 'MasterMaklunController@delete');

Route::get('/shippingmethod', 'RefShippingMethodController@index');





