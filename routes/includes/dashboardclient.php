<?php

use Illuminate\Support\Facades\Route;


Route::get('/dashboardclientorder/{id}', 'DashboardClientController@getOrder');
Route::get('/dashboardclientordermenunggupembayaran/{id}', 'DashboardClientController@getOrderMenungguPembayaran');
Route::get('/dashboardclientorderpembayaranterkonfirmasi/{id}', 'DashboardClientController@getOrderPembayaranTerkonfirmasi');
Route::get('/dashboardclientordermenunggupickup/{id}', 'DashboardClientController@getOrderMenungguPickup');
Route::get('/dashboardclientpesanandalampengiriman/{id}', 'DashboardClientController@getOrderPesananDalamPengiriman');
Route::get('/dashboardclientprosesjahit/{id}', 'DashboardClientController@getOrderProsesJahit');
Route::get('/dashboardclientdalampengantaran/{id}', 'DashboardClientController@getOrderDalamPengantaran');
Route::get('/dashboardclienttambahanbiaya/{id}', 'DashboardClientController@getOrderTambahanBiaya');
Route::get('/dashboardclientpesananselesai/{id}', 'DashboardClientController@getOrderPesananSelesai');
Route::get('/dashboardclientpesananditerima/{id}', 'DashboardClientController@getOrderPesananDiterima');
Route::post('/ubahstatusorderdetailId/{id}', 'DashboardClientController@update');


Route::post('/ubahkonfirmasipengerjaanorderdetailId/{id}', 'DashboardClientController@updatekonfirmasi');
Route::get('/dashboardclient', 'DashboardClientController@getAllItem');

Route::get('/dashboardclient/{id}', 'DashboardClientController@getItemById');
Route::get('/dashboardclient/clientId/{id}', 'DashboardClientController@getItemByClientId');
Route::get('/dashboardclient/clientId/{clientid}/itemId/{itemid}', 'DashboardClientController@getServiceByItemId');
Route::post('/dashboardclient', 'DashboardClientController@store');
Route::get('/dashboardclient/userId/{userid}', 'DashboardClientController@show');
Route::delete('/dashboardclient/userId/{userid}/service/{serviceid}', 'DashboardClientController@destroyservice');

Route::delete('/dashboardclient/userId/{id}', 'DashboardClientController@destroy');
Route::post('/dashboardclient/checkout', 'DashboardClientController@checkout');



