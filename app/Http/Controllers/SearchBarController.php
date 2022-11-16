<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SearchBarController extends Controller
{


    public function searchBar($keyword)
    {


        $data = DB::table('users')
        ->join('taylors', 'users.id', '=', 'taylors.user_id')
        ->join('services', 'taylors.id', '=', 'services.taylor_id')
        ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
         ->where('services.name', 'like', '%'.$keyword.'%' )
         ->orwhere('users.name', 'like', '%'.$keyword.'%' )
         ->orwhere('service_categories.name', 'like', '%'.$keyword.'%' )
        ->select([
            'users.id as userId', 'users.name as taylorName', 'service_categories.id as itemId', 'service_categories.name as itemName', 'taylors.photo as taylorPhoto', 'service_categories.photo as servicePhoto', 'services.price as servicePrice', 'services.name as serviceName'
        ])
        ->get();



        if($data) {
            return apiResponse(200, 'success', 'List data', $data);
        } if(count($data) < 1 ) {
            return Response::json(apiResponse(404, 'not found', 'Data tidak dapat ditemukan'), 404);
        }

    }


}
