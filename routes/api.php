<?php
use Illuminate\Support\Facades\Route;

require_once('includes/auth.php');
// require_once('includes/taylor.php');
// require_once('includes/item.php');
// require_once('includes/sectionitem.php');
// require_once('includes/service.php');
// require_once('includes/user.php');

Route::group(
    ['middleware' => 'auth:api'],
    function() {

        require_once('includes/taylor.php');
        require_once('includes/item.php');
        require_once('includes/sectionitem.php');
        require_once('includes/service.php');
        require_once('includes/user.php');

        require_once('includes/profile.php');

        require_once('includes/kategori.php');;
    }
);
