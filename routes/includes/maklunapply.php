<?php

use Illuminate\Support\Facades\Route;

Route::post('/maklun/{maklunid}/apply/{userid}', 'MaklunApplyController@create');
