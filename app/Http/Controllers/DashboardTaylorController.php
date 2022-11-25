<?php

namespace App\Http\Controllers;

use App\Service;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Cart;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardTaylorController extends Controller
{
    public function getOrder($id) {

        $orders = DB::table('orders as a')
            ->join('order_details as b', 'a.id', '=', 'b.order_id')
            ->join('services as c', 'b.service_id', '=', 'c.id')
            ->join('taylors as d', 'c.taylor_id', '=', 'd.id')
            ->join('users as e', 'd.user_id', '=', 'e.id')
            ->join('users as f', 'f.id', '=', 'a.user_id')
            ->join('addresses as g', 'g.user_id', '=', 'f.id')
            ->join('address_labels as h', 'g.addresslabel_id', '=', 'h.id')
            ->join('provinces as i', 'i.id', '=', 'g.province_id')
            ->join('regencies as j', 'j.id', '=', 'g.regency_id')
            ->join('districts as k', 'k.id', '=', 'g.district_id')
            ->join('villages as l', 'l.id', '=', 'g.village_id')
            ->select([
                'b.id','a.invoice',
	            'a.created_at as tgl_order',
	            'f.name as namapembeli',
                DB::raw("CONCAT(g.fullAddress,' ','Kel/Ds.',' ', l.name, ' Kec. ', k.name,' Kab/Kota. ', j.name,' Prov. ', i.name,' ', g.posCode) as alamat"),
                'c.NAME AS jasa',
                'b.quantity',
                'b.price',
                'b.orderStatus',
                'a.paymentStatus',
                'b.pickup',
                'e.NAME AS namapenjahit',
                'b.photoClient1',
                'b.photoTaylor1'
            ])->where('c.taylor_id', $id)
            ->where('g.addresslabel_id', 1)
            ->latest('a.created_at')
            ->paginate(10000);

        if($orders->total() >0 ) {
            return apiResponse(200, 'success', 'list data Order Masuk', $orders);
        } else{
            return Response::json(apiResponse(404, 'not found', 'Order Masuk tidak ditemukan'), 404);
        }
    }






    public function update(Request $request, $id) {
        $rules = [
            // 'quantity'         => 'required',
        ];

        $message = [
            // 'quantity.required'        => 'Mohon isikan quantity',
        ];

          $validator = Validator::make($request->all(), $rules, $message);

          if($validator->fails()) {
              return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
          }

          try {
              DB::transaction(function () use ($request, $id) {
                  OrderDetail::where('id', $id)->

                  update([

                      'orderStatus' => 'Proses Jahit',
                  ]);
              });

              return apiResponse(202, 'success', 'status Order berhasil dirubah');
          } catch(Exception $e) {
              return apiResponse(400, 'error', 'error', $e);
          }
      }

      public function updatekonfirmasi(Request $request, $id) {
        $rules = [
             'photoTaylor1'         => 'required',
        ];

        $message = [
            'photoTaylor1.required'        => 'Mohon isikan Photo',
        ];

          $validator = Validator::make($request->all(), $rules, $message);

          if($validator->fails()) {
              return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
          }

          if($request->has('photoTaylor1')) {


            $extension = $request->file('photoTaylor1')->getClientOriginalExtension();
            //$name = date('YmdHis').'.'.$extension;
            $name = date('YmdHis').''.Str::uuid().'.'.$extension;
            $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-cart/';
            $request->file('photoTaylor1')->move($path, $name);





        }

          try {
              DB::transaction(function () use ($request, $id,$name) {
                  OrderDetail::where('id', $id)->
                  update([
                      'orderStatus' => 'Pesanan Selesai',
                      'photoTaylor1'  => $name,
                  ]);
              });
              return apiResponse(202, 'success', 'status Order berhasil dirubah');
          } catch(Exception $e) {
              return apiResponse(400, 'error', 'error', $e);
          }
      }








}
