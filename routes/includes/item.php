<?php

use Illuminate\Support\Facades\Route;

Route::get('/item', 'ItemController@getAllItem');
Route::get('/item/{keyword}', 'ItemController@getItemByName');


