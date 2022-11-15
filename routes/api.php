<?php
use Illuminate\Support\Facades\Route;

require_once('includes/auth.php');
require_once('includes/user.php');

Route::group(
    ['middleware' => 'auth:api'],
    function() {

        require_once('includes/profile.php');
        require_once('includes/brand.php');
        require_once('includes/kategori.php');
        require_once('includes/team.php');
        require_once('includes/product.php');
    }
);
