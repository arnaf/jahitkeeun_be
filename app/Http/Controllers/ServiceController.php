<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ServiceController extends Controller
{
    public function getServiceByName($keyword) //Mencari data service search bar
    {



        $service = DB::table('users')
        ->join('taylors', 'users.id', '=', 'taylors.user_id')
        ->join('services', 'taylors.id', '=', 'services.taylor_id')
        ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
        ->where('services.name', 'like', '%'.$keyword.'%' )
        ->select([
            'taylors.id as taylorId', 'users.name as taylorName', 'services.id as serviceId', 'services.name as serviceName'
        ])
        ->get();




            if(!$service == NULL) {
                foreach($service as $s) {
                    $dataJasa[] = [
                        'taylorId'          => $s->taylorId,
                        'taylorName'        => $s->taylorName,
                        'serviceId'         => $s->itemId,
                        'serviceName'       => $s->itemName,

                    ];
                }

            }

        if($service) {
            return apiResponse(200, 'success', 'list data jasa', $dataJasa);
        }
        return Response::json(apiResponse(404, 'not found', 'Jasa tidak ditemukan'), 404);




    }
}
