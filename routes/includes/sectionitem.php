<?php

use Illuminate\Support\Facades\Route;

Route::get('/sectionitemalamat/{id}', 'SectionItemController@getAlamat');
Route::get('/sectionitem', 'SectionItemController@getAllItem');
Route::get('/sectionitem/{id}', 'SectionItemController@getTaylorsByItemId');
Route::get('/sectionitem/taylorId/{id}', 'SectionItemController@getItemByTaylorId');
Route::get('/sectionitem/taylorId/{taylorid}/itemId/{itemid}', 'SectionItemController@getServiceByItemId');
Route::post('/sectionitem', 'SectionItemController@store');
Route::get('/sectionitem/userId/{userid}', 'SectionItemController@show');
Route::delete('/sectionitem/userId/{userid}/service/{serviceid}', 'SectionItemController@destroyservice');
Route::post('/sectionitem/userId/{userid}/service/{serviceid}', 'SectionItemController@update');
Route::delete('/sectionitem/userId/{id}', 'SectionItemController@destroy');
Route::post('/sectionitem/checkout', 'SectionItemController@checkout');
Route::post('/sectionitem/selectedcheckout', 'SectionItemController@checkoutBySelectedCart');



