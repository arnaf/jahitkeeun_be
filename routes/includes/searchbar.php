<?php

use Illuminate\Support\Facades\Route;

Route::get('/search/{keyword}', 'SearchBarController@searchBar');
