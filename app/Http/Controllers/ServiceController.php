<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ServiceController extends Controller
{



    // public function index() {
    //     $services = DB::table('services')->get();

    //     return apiResponse(200, 'success', 'List jasa', $services);
    // }



    public function getServiceByName($keyword) //Mencari data service search bar
    {




        $service = DB::table('users')
        ->join('taylors', 'users.id', '=', 'taylors.user_id')
        ->join('services', 'taylors.id', '=', 'services.taylor_id')
        ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
        ->where('services.name', 'like', '%'.$keyword.'%' )
        ->select([
            'users.id as userId', 'users.name as taylorName', 'service_categories.id as itemId', 'service_categories.name as itemName', 'taylors.photo as taylorPhoto', 'service_categories.photo as servicePhoto', 'services.price as servicePrice'
        ])
        ->limit(10)->get();


        if(count($service) > 0) {

            return apiResponse(200, 'success', 'list data jasa', $service);

        } elseif(count($service) < 1) {

            return Response::json(apiResponse(404, 'not found', 'Jasa tidak ditemukan'), 404);

        }



    }
}
