<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ItemController extends Controller
{
    public function getAllItem() {

        $item = DB::table('service_categories')
            ->select([
                'service_categories.id', 'service_categories.name'
            ])
            ->first();

            if(!$item == NULL) {
                $dataItem = [
                    'id'          => $item->id,
                    'name'        => $item->name,

                ];
            }

        if($item) {
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
            ->first();

            if(!$item == NULL) {
                $dataItem = [
                    'taylorId'          => $item->taylorId,
                    'taylorName'        => $item->taylorName,
                    'itemId'            => $item->itemId,
                    'itemName'           => $item->itemName,

                ];
            }

        if($item) {
            return apiResponse(200, 'success', 'list data Item', $dataItem);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }
}
