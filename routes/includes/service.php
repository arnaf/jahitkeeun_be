<?php

use Illuminate\Support\Facades\Route;



Route::get('/service/{keyword}', 'ServiceController@getServiceByName');

