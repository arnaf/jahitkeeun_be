<?php

namespace App\Http\Controllers;

use App\Service;
use App\Order;
use App\OrderDetail;

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

        $address = DB::table('orders as a')
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
                'a.orderStatus',
                'a.paymentStatus',
                'b.pickup',
                'e.NAME AS namapenjahit',
                'b.photoClient1',
                'b.photoTaylor1'
            ])->where('c.taylor_id', $id)->
            where('g.addresslabel_id', 1)->
            get();

        if($address) {
            return apiResponse(200, 'success', 'list data Order Masuk', $address);
        }
        return Response::json(apiResponse(404, 'not found', 'Order Masuk tidak ditemukan'), 404);
    }


    public function store(Request $request) {
        $rules = [
            'user_id'         => 'required',
            'service_id'         => 'required',
            'quantity'         => 'required',
            'pickup'         => 'required',


        ];

        $message = [
            'user_id.required'        => 'Mohon isikan user id',
            'service_id.required'        => 'Mohon isikan product id',
            'quantity.required'        => 'Mohon isikan quantity',
            'pickup.required'        => 'Mohon isikan tanggal pickup',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }
        if($request->has('photoClient1')) {


            $extension = $request->file('photoClient1')->getClientOriginalExtension();
            //$name = date('YmdHis').'.'.$extension;
            $name = date('YmdHis').''.$request->service_id.''.$request->user_id.'.'.$extension;
            $path = base_path('public/photo-cart/');
            $request->file('photoClient1')->move($path, $name);

        }

        try {

            DB::transaction(function () use ($request,$name) {

                $id = Cart::insertGetId([
                    'user_id'  => $request->user_id,
                    'service_id'  => $request->service_id,
                    'quantity'  => $request->quantity,
                    'pickup'  => $request->pickup,
                    'photoClient1'  => $name,
                ]);



            });

            return apiResponse(201, 'success', 'Cart berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
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

                      'orderStatus' => 'Proses Pengerjaan',
                  ]);
              });

              return apiResponse(202, 'success', 'status Order berhasil dirubah');
          } catch(Exception $e) {
              return apiResponse(400, 'error', 'error', $e);
          }
      }

      public function destroy($id) {
        try {

            DB::transaction(function () use ($id) {
              Cart::where('user_id', $id)->delete();

            });

            return apiResponse(202, 'success', 'cart berhasil dikosongkan :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }




    public function checkout(Request $request)
    {

        $rules = [
            'user_id'                       => 'required',
            'amount'                        => 'required',
            'address'                       => 'required',
            'deliveries_id'                 => 'required',
            'payment_method_id'             => 'required',
            'shipping_method_id'            => 'required',

        ];

        $message = [
            'user_id.required'                  => 'Mohon isikan user id',
            'amount.required'                   => 'Mohon isikan amount',
            'addreess.required'                 => 'Mohon isikan alamat',
            'deliveries_id.required'            => 'Mohon isikan alamat',
            'payment_method_id.required'        => 'Mohon isikan alamat',
            'shipping_method_id.required'       => 'Mohon isikan alamat',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {


                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'totalPayment' => $request->amount,
                    'paymentStatus' => 'BELUM BAYAR',
                    'orderStatus' => 'Menunggu Pickup',

                    'address' => $request->address,
                    'deliveries_id' => $request->deliveries_id,
                    'payment_method_id' => $request->payment_method_id,
                    'shipping_method_id' => $request->shipping_method_id,
                ]);


                $cart = $request->user()->cart()->get();
                foreach ($cart as $item) {
                    $order->items()->create([
                        'price' => $item->price * $item->pivot->quantity,
                        'quantity' => $item->pivot->quantity,
                        'service_id' => $item->id,
                        'pickup' => $item->pickup,
                        'photoClient1' => $request->photoClient1,
                        'photoClient2' => $request->photoClient2,
                        'photoClient3' => $request->photoClient3,
                        'photoClient4' => $request->photoClient4,
                        'photoClient5' => $request->photoClient5,
                    ]);
                    // $item->quantity = $item->quantity - $item->pivot->quantity;
                    // $item->save();
                }
                $request->user()->cart()->detach();
                $order->payments()->create([
                    'paymentAmount' => $request->amount,
                    'user_id' => $request->user()->id,
                ]);




            });

            return apiResponse(201, 'success', 'Checkout berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }

    }

}
