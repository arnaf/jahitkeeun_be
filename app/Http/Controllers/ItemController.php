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
                'service_categories.id as itemId', 'service_categories.name as itemName', 'service_categories.photo as itemPhoto'
            ])
            ->get();


        if($items) {
            return apiResponse(200, 'success', 'list data Item', $items);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }



    
}
