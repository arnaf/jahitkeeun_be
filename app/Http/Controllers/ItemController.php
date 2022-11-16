<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ItemController extends Controller
{
    public function getAllItem() {

        $items = DB::table('service_categories')
            ->select([
                'service_categories.id', 'service_categories.name', 'service_categories.photo'
            ])
            ->get();

            if(!$items == NULL) {
                foreach($items as $i){
                    $dataItem[] = [
                        'id'          => $i->id,
                        'name'        => $i->name,
                        'photo'       => $i->photo
                    ];
                }

            }

        if($items) {
            return apiResponse(200, 'success', 'list data Item', $dataItem);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }



    public function getItemByName($keyword) {

        $item = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
        ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
            ->where('service_categories.name', 'like', '%'.$keyword.'%' )
            ->select([
                'taylors.id as taylorId', 'users.name as taylorName', 'service_categories.id as itemId', 'service_categories.name as itemName'
            ])
            ->get();

            if(!$item == NULL) {
                foreach($item as $i) {
                    $dataItem[] = [
                        'taylorId'          => $i->taylorId,
                        'taylorName'        => $i->taylorName,
                        'itemId'            => $i->itemId,
                        'itemName'          => $i->itemName,

                    ];
                }

            }

        if($item) {
            return apiResponse(200, 'success', 'list data Item', $dataItem);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }
}
