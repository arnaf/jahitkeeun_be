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
        ->join('addresses', 'users.id', '=', 'addresses.user_id')
        ->join('regencies', 'regencies.id', '=', 'addresses.regency_id')
        ->join('services', 'taylors.id', '=', 'services.taylor_id')
        ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
         ->where('services.name', 'like', '%'.$keyword.'%' )
         ->orwhere('users.name', 'like', '%'.$keyword.'%' )
         ->orwhere('service_categories.name', 'like', '%'.$keyword.'%' )
        ->select([
            'services.id as serviceId', 'services.name as serviceName', 'services.price',
            'taylor_id as taylorId','users.name as taylorName'
        ])
        ->orderBy('users.name')
        ->groupBy('services.id','services.name','services.price','taylor_id',
        'users.name'
         )
        ->paginate();


        if($data) {
            return apiResponse(200, 'success', 'List data', $data);
        } if(count($data) < 1 ) {
            return Response::json(apiResponse(404, 'not found', 'Data tidak dapat ditemukan'), 404);
        }

    }


}
