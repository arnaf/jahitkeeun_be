<?php

namespace App\Http\Controllers;

use App\Service;
use App\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Cart;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SectionItemController extends Controller
{
    public function getAllItem() {


        $items = DB::table('service_categories')
            ->select([
                'service_categories.id as itemId', 'service_categories.name as itemName', 'service_categories.photo as itemPhoto'
            ])
            ->latest()
            ->paginate();



        if($items) {
            return apiResponse(200, 'success', 'list data Item', $items);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }



    public function getItemById($id) {


        $taylors = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('regencies', 'regencies.id', '=', 'addresses.regency_id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
            ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
            ->where('service_categories_id', $id)
            ->select([
                'taylors.id as taylorId','users.name as taylorName','taylors.photo as photo',
                'taylors.phone as phone','regencies.name as kota','taylors.rating as rating'
            ])
            ->orderBy('users.name')
            ->groupBy('users.name','taylors.id','taylors.photo','taylors.phone','regencies.name',
            'taylors.rating')
            ->paginate();


        if($taylors) {
            return apiResponse(200, 'success', 'list data Taylor By Item Id', $taylors);
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
            ->orderBy('users.name')
            ->groupBy('service_categories.id','service_categories.name','service_categories.photo' )
            ->paginate();


        if($items) {
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
                'services.id as serviceId', 'services.name as serviceName', 'services.price',
                'taylor_id as taylorId','users.name as taylorName'
            ])
            ->orderBy('users.name')
            ->groupBy('services.id','services.name','services.price','taylor_id',
            'users.name' )
            ->paginate();


        if($services) {
            return apiResponse(200, 'success', 'list data Service By Item Id', $services);
        }
        return Response::json(apiResponse(404, 'not found', 'Item tidak ditemukan'), 404);
    }

    public function store(Request $request) {
        $rules = [
            'user_id'         => 'required',
            'service_id'         => 'required',
            'quantity'         => 'required',


        ];

        $message = [
            'user_id.required'        => 'Mohon isikan user id',
            'service_id.required'        => 'Mohon isikan product id',
            'quantity.required'        => 'Mohon isikan quantity',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $id = Cart::insertGetId([
                    'user_id'  => $request->user_id,
                    'service_id'  => $request->service_id,
                    'quantity'  => $request->quantity,
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
        ->join('services as c', 'a.id', '=', 'c.id')
        ->join('service_categories as d', 'c.service_categories_id', '=', 'd.id')
        ->join('taylors as e', 'c.taylor_id', '=', 'e.id')
        ->join('users as f', 'e.user_id', '=', 'f.id')

        ->where('a.user_id', $userid)
        ->select([
            'b.id as userId','b.name as namapembeli',
            'd.name as item','d.photo as photoItem',
            'f.name as namataylor',
            'c.id as serviceId',
            'c.name as serviceName',
            'a.quantity as quantity', 'c.price',

        ])
        ->orderBy('a.id')

        ->paginate();

        if($cart1) {
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
            'user_id'         => 'required',
            'amount'         => 'required',
        ];

        $message = [
            'user_id.required'        => 'Mohon isikan user id',
            'amount.required'        => 'Mohon isikan amount',

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
                     'invoice' => 'INV',
                     'address' => 'Bandung',
                     'deliveries_id' => '1',
                     'payment_method_id' => '1',
                     'shipping_method_id' => '1',
                ]);

                $cart = $request->user()->cart()->get();
                foreach ($cart as $item) {
                    $order->items()->create([
                        'price' => $item->price * $item->pivot->quantity,
                        'quantity' => $item->pivot->quantity,
                        'service_id' => $item->id,
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

            return apiResponse(201, 'success', 'Cart berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }

    }

}
