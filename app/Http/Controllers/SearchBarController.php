<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SearchBarController extends Controller
{


    public function searchBar(Request $request)
    {

        if($request->keyword == NULL){
            return Response::json(apiResponse(404, 'NULL Keyword', 'Keyword kosong'), 404);
        }
        else if(!$request->keyword == NULL) {
            $data = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('provinces', 'provinces.id', '=', 'addresses.province_id')
            ->join('regencies', 'regencies.id', '=', 'addresses.regency_id')
            ->join('districts', 'regencies.id', 'districts.regency_id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
            ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')

            ->where('users.name', 'like', '%'.$request->keyword.'%' )
            ->Orwhere('services.name', 'like', '%'.$request->keyword.'%' )
            ->Orwhere('service_categories.name', 'like', '%'.$request->keyword.'%' )

            ->select([
                'taylors.id as taylorId', 'users.name as taylorName', 'districts.name as districtName', 'taylors.rating as taylorRating', 'taylors.completedTrans as taylorComtrans', 'taylors.photo as taylorPhoto'
            ])
            ->orderBy('users.name')
            ->groupBy('users.name')
            // ->groupBy('users.name', 'taylors.id', 'taylors.rating', 'taylors.completedTrans', 'taylors.photo'
            //  )
            ->paginate();
            // 'addresses.fullAddress as fullAddress', 'provinces.name as provinceName', 'regencies.name as regencyName',

            if($data->total() > 0) {
                return apiResponse(200, 'success', 'List data', $data);
            } if($data->total() < 1 ) {
                return Response::json(apiResponse(404, 'not found', 'Data tidak dapat ditemukan'), 404);
            }
        }


    }


}
