<?php

use Illuminate\Support\Facades\Route;

Route::get('/wilayah/provinsi', 'WilayahController@getAllProvince');
Route::get('/wilayah/kabkot/{id}', 'WilayahController@getRegencyByProvinceId');
Route::get('/wilayah/kecamatan/{id}', 'WilayahController@getDistrictByRegencyId');
Route::get('/wilayah/deskel/{id}', 'WilayahController@getVillageByDistrictId');
