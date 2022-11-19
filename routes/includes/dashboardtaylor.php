<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboardtayloralamat/{id}', 'DashboardTaylorController@getAlamat');
Route::get('/dashboardtaylororder/{id}', 'DashboardTaylorController@getOrder');
Route::get('/dashboardtaylor', 'DashboardTaylorController@getAllItem');

Route::get('/dashboardtaylor/{id}', 'DashboardTaylorController@getItemById');
Route::get('/dashboardtaylor/taylorId/{id}', 'DashboardTaylorController@getItemByTaylorId');
Route::get('/dashboardtaylor/taylorId/{taylorid}/itemId/{itemid}', 'DashboardTaylorController@getServiceByItemId');
Route::post('/dashboardtaylor', 'DashboardTaylorController@store');
Route::get('/dashboardtaylor/userId/{userid}', 'DashboardTaylorController@show');
Route::delete('/dashboardtaylor/userId/{userid}/service/{serviceid}', 'DashboardTaylorController@destroyservice');
Route::post('/dashboardtaylor/userId/{userid}/service/{serviceid}', 'DashboardTaylorController@update');
Route::delete('/dashboardtaylor/userId/{id}', 'DashboardTaylorController@destroy');
Route::post('/dashboardtaylor/checkout', 'DashboardTaylorController@checkout');



