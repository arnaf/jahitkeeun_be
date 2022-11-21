<?php
use Illuminate\Support\Facades\Route;

require_once('includes/auth.php');




require_once('includes/searchbar.php');
require_once('includes/datamaster.php');


Route::group(
    ['middleware' => 'auth:api'],
    function() {




        require_once('includes/taylorsection.php');
        require_once('includes/item.php');
        require_once('includes/sectionitem.php');
        require_once('includes/dashboardtaylor.php');

        require_once('includes/user.php');
        require_once('includes/maklunapply.php');

        require_once('includes/profile.php');
        require_once('includes/wilayahbandung.php');



        require_once('includes/kategori.php');;
    }
);
