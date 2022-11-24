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

class SectionItemController extends Controller
{
    public function getAlamat($id) {


        $address = DB::table('addresses as a')
            ->join('address_labels as b', 'a.addresslabel_id', '=', 'b.id')
            ->join('provinces as c', 'c.id', '=', 'a.province_id')
            ->join('regencies as d', 'd.id', '=', 'a.regency_id')
            ->join('districts as e', 'e.id', '=', 'a.district_id')
            ->join('villages as f', 'f.id', '=', 'a.village_id')
            ->select([
                'a.user_id as userId','a.id as alamatId','b.name as jenisAlamat',
                DB::raw("CONCAT(a.fullAddress,' ','Kel/Ds.',' ', f.name, ' Kec. ', e.name,' Kab/Kota. ', d.name,' Prov. ', c.name,' ', a.posCode) as alamat")
            ])->where('a.user_id', $id)
            ->get();

        if($address) {
            return apiResponse(200, 'success', 'list data Alamat', $address);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }

    public function getAllItem() {


        $items = DB::table('service_categories')
            ->select([
                'service_categories.id as itemId', 'service_categories.name as itemName', 'service_categories.photo as itemPhoto'
            ])
            ->latest()
            ->paginate();



        if($items->total() >0) {
            return apiResponse(200, 'success', 'list data Item', $items);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }



    public function getTaylorsByItemId($id) {


        $Items = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('regencies', 'regencies.id', '=', 'addresses.regency_id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
            ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
            ->where('service_categories_id', $id)
            ->select([
                'taylors.id as taylorId','users.name as taylorName','taylors.photo as photo',
                'taylors.phone as phone','regencies.name as kota','taylors.rating as rating',
                'taylors.completedTrans as jumlah_transaksi'
            ])
            ->orderBy('users.name')
            ->groupBy('users.name','taylors.id','taylors.photo','taylors.phone','regencies.name',
            'taylors.rating', 'taylors.completedTrans')
            ->paginate();


        if($Items->total() > 0) {
            return apiResponse(200, 'success', 'list data Taylor By Item Id', $Items);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }

    public function getItemByTaylorId($id) {


        $items = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('regencies', 'regencies.id', '=', 'addresses.regency_id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
            ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
            ->where('taylor_id', $id)
            ->select([
                'service_categories.id as itemId', 'service_categories.name as itemName', 'service_categories.photo as itemPhoto'
            ])
            ->orderBy('service_categories.id')
            ->groupBy('service_categories.id','service_categories.name','service_categories.photo' )
            ->paginate();


        if($items->total() > 0) {
            return apiResponse(200, 'success', 'list data Item By Taylor Id', $items);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }

    public function getServiceByItemId($taylorid,$itemtid) {


        $services = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('regencies', 'regencies.id', '=', 'addresses.regency_id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
            ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
            ->where('service_categories_id', $itemtid)
            ->where('taylor_id', $taylorid)
            ->select([
                'services.id as serviceId', 'services.name as serviceName', 'services.price as servicePrice',
                'taylors.id as taylorId','users.name as taylorName'
            ])
            ->orderBy('services.id')
            ->groupBy('services.id','services.name','services.price','taylors.id',
            'users.name' )
            ->paginate();


        if($services->total() > 0) {
            return apiResponse(200, 'success', 'list data Service By Item Id', $services);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
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
            $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-cart/';
            $request->file('photoClient1')->move($path, $name);

        }

        try {

            DB::transaction(function () use ($request,$name) {

                $id = Cart::insertGetId([
                    'user_id'  => $request->user_id,
                    'service_id'  => $request->service_id,
                    'quantity'  => $request->quantity,
                    'desc'      => $request->desc,
                    'pickup'  => $request->pickup,
                    'photoClient1'  => $name,
                ]);



            });

            return apiResponse(201, 'success', 'Cart berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function show($userid) {

        $cart1 = DB::table('carts as a')
        ->join('users as b', 'b.id', '=', 'a.user_id')

        ->join('services as c', 'a.service_id', '=', 'c.id')
        ->join('service_categories as d', 'c.service_categories_id', '=', 'd.id')
        ->join('taylors as e', 'c.taylor_id', '=', 'e.id')
        ->join('users as f', 'e.user_id', '=', 'f.id')
        ->join('addresses as g', 'g.user_id', '=', 'b.id')

        ->where('a.user_id', $userid)
        ->where('g.addresslabel_id', '=', '1')
        ->select([
            'b.id as userId','b.name as namapembeli',
            'g.fullAddress as alamatpembeli',
            'd.name as item','d.photo as photoItem',
            'f.name as namataylor',
            'c.id as serviceId',
            'c.name as serviceName',
            'a.quantity as quantity', 'c.price', 'a.desc as description',
            'a.photoClient1 as photoRef','a.pickup'

        ])
        ->orderBy('a.id', 'desc')

        ->paginate();

        if($cart1->total() > 0) {
            return apiResponse(200, 'success', 'list data Carts By User Id', $cart1);
        }

        return Response::json(apiResponse(404, 'not found', 'cart tidak ditemukan :('), 404);
    }

    public function destroyservice($userid,$serviceid) {
        try {

            DB::transaction(function () use ($userid,$serviceid) {
              Cart::where('user_id', $userid)->
              where('service_id', $serviceid)->
              delete();

            });

            return apiResponse(202, 'success', 'cart berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $userid,$serviceid) {
        $rules = [
            'quantity'         => 'required',
        ];

        $message = [
            'quantity.required'        => 'Mohon isikan quantity',
        ];

          $validator = Validator::make($request->all(), $rules, $message);

          if($validator->fails()) {
              return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
          }

          try {
              DB::transaction(function () use ($request, $userid,$serviceid) {
                  Cart::where('user_id', $userid)->
                  where('service_id', $serviceid)->
                  update([

                      'quantity' => $request->quantity,
                  ]);
              });

              return apiResponse(202, 'success', 'Quantity Cart berhasil dirubah');
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

            'amount'                        => 'required',
            'address'                       => 'required',
            'deliveries_id'                 => 'required',
            'payment_method_id'             => 'required',
            'shipping_method_id'            => 'required',

        ];

        $message = [

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





                $cart = $request->user()->cart()->get();
                //dd($cart);


                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'totalPayment' => $request->amount,
                    'paymentStatus' => 'BELUM BAYAR',
                    'orderStatus' => 'Menunggu Pickup',
                    'estimationDate' => $request->estimationdate,
                    'address' => $request->address,
                    'deliveries_id' => $request->deliveries_id,
                    'payment_method_id' => $request->payment_method_id,
                    'shipping_method_id' => $request->shipping_method_id,
                ]);

                foreach ($cart as $item) {

                    $order->items()->create([
                        'price' => $item->price * $item->pivot->quantity,
                        'quantity' => $item->pivot->quantity,
                        'pickup' => $item->pivot->pickup,
                        'desc' => $item->pivot->desc,
                        'photoClient1' => $item->pivot->photoClient1,
                        'service_id' => $item->id,
                        'orderStatus' => 'Menunggu Pembayaran',
                        // 'pickup'   => $item->pivot->pickup,
                        // 'desc'   => $item->pivot->desc,
                        // 'photoClient1' => $item->pivot->photoClient1,
                        // 'photoClient2' => '',
                        // 'photoClient3' => '',
                        // 'photoClient4' => '',
                        // 'photoClient5' => '',
                        // 'photoTaylor1' => '',
                        // 'photoTaylor2' => '',
                        // 'photoTaylor3' => '',
                        // 'photoTaylor4' => '',
                        // 'photoTaylor5' => '',
                        // 'orderStatus' => '',


                    ]);


                }
                $request->user()->cart()->detach();

                // $cart1 = OrderDetail::insert([
                //     'quantity'  => 1,
                //     'price'  => 135000,
                //     'service_id'  => 22,
                //     'order_id'  => 10,
                //     'desc'      => 'Ini deskripsi',
                //     'pickup' => now(),
                //     'photoClient1'  => 'photoclient1.png',
                //     'photoClient2'  => 'photoclient2.png',
                //     'photoClient3'  => 'photoclient3.png',
                //     'photoClient4'  => 'photoclient4.png',
                //     'photoClient5'  => 'photoclient5.png',
                //     'photoTaylor1'  => 'phototaylor1.png',
                //     'photoTaylor2'  => 'phototaylor1.png',
                //     'photoTaylor3'  => 'phototaylor1.png',
                //     'photoTaylor4'  => 'phototaylor1.png',
                //     'photoTaylor5'  => 'phototaylor1.png',
                //     'orderStatus'=> 'Proses Order Customer',

                // ]);
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

    public function checkoutBySelectedCart(Request $request)
    {



            $rules = [
                'user_id'                       => 'required',
                'amount'                        => 'required',
                'address'                       => 'required',
                'deliveries_id'                 => 'required',
                'payment_method_id'             => 'required',
                'shipping_method_id'            => 'required',
                'service_id'                    => 'required',

            ];

            $message = [
                'user_id.required'                  => 'Mohon isikan user id',
                'amount.required'                   => 'Mohon isikan amount',
                'addreess.required'                 => 'Mohon isikan alamat',
                'deliveries_id.required'            => 'Mohon isikan delivery',
                'payment_method_id.required'        => 'Mohon isikan metode pembayaran',
                'shipping_method_id.required'       => 'Mohon isikan metode pengiriman',
                'service_id.required'               => 'Mohon isikan jasa',

            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
            }

            try{
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


                    $cart = $request->user()->cart()
                            ->where('services.id', $request->service_id)->get();
                    foreach ($cart as $item) {
                        $order->items()->create([
                            'price' => $item->price * $item->pivot->quantity,
                            'quantity' => $item->pivot->quantity,
                            'service_id' => $item->id,
                            'pickup' => $item->pickup,
                            'desc'   => $item->desc,
                            'photoClient1' => $request->photoClient1,
                            'photoClient2' => $request->photoClient2,
                            'photoClient3' => $request->photoClient3,
                            'photoClient4' => $request->photoClient4,
                            'photoClient5' => $request->photoClient5,
                        ]);
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


