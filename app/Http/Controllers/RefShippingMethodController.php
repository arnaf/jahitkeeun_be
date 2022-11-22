<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RefShippingMethodController extends Controller
{
    public function index()
    {

        $shippings = DB::table('shipping_methods')
                ->select(['shipping_methods.id as shpping_method_id', 'shipping_methods.name as shipping_method_name', 'shipping_methods.photo as shipping_method_photo',])
                ->paginate();


                if($shippings->total() > 0) {
                    return apiResponse(200, 'success', 'List metode pengiriman', $shippings);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data metode pengiriman tidak ditemukan'), 404);
                }
    }
}
