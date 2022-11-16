<?php

use Illuminate\Support\Facades\Route;

Route::get('/taylor', 'SectionTaylorController@getAllTaylor');
Route::get('/taylor/rating/{i}', 'SectionTaylorController@getTaylorByRating');
Route::get('/taylor/price/{i}', 'SectionTaylorController@getTaylorByPrice');
Route::get('/taylor/regency/{id}', 'SectionTaylorController@getTaylorByRegency');

