<?php

namespace App\Http\Controllers;

use Exception;
use App\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterDeliveryController extends Controller
{
    public function index()
    {

        $deliveries = DB::table('deliveries')
                ->select(['deliveries.id as id', 'deliveries.name as delivery_name', 'deliveries.photo as delivery_photo', 'deliveries.addressFrom as address_from', 'deliveries.addressTo as address_to', 'deliveries.price as delivery_price'])
                ->paginate();


                if($deliveries->total() > 0) {
                    return apiResponse(200, 'success', 'List delivery', $deliveries);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data delivery tidak ditemukan'), 404);
                }

    }

    public function show($id) {
        $delivery = DB::table('deliveries')
                    ->select(['deliveries.id as id', 'deliveries.name as delivery_name', 'deliveries.photo as delivery_photo', 'deliveries.addressFrom as address_from', 'deliveries.addressTo as address_to', 'deliveries.price as delivery_price'])
                    ->where('id', $id)
                    ->paginate();

                    if($delivery = DB::table('deliveries')
                    ->total() > 0) {
                        return apiResponse(200, 'success', 'List delivery', $delivery);
                    } else {
                        return Response::json(apiResponse(404, 'not found', 'Data delivery tidak ditemukan'), 404);
                    }
    }


    public function create(Request $request) {



        $rules = [
            'name'        => 'required',
            'addressFrom' => 'required',
            'addressTo'   => 'required',
            'price'       => 'required',


        ];

        $message = [
            'name.required'         => 'Mohon isikan nama agen kurir',
            'addressFrom.required'  => 'Mohon isikan daerah asal',
            'addressTo.required'    => 'Mohon isikan daerah tujuan',
            'price.required'        => 'Mohon isikan biaya pengantaran',


        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {


            if($request->has('photo')){


                $extension = $request->file('photo')->getClientOriginalExtension();

                $deliveryPhoto = date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/delivery/');

                $request->file('photo')->move($path, $deliveryPhoto);

            }

            DB::transaction(function () use ($request, $deliveryPhoto) {
                $delivery = Delivery::create([
                    'name'          => $request->name,
                    'photo'         => $deliveryPhoto,
                    'addressFrom'   => $request->addressFrom,
                    'addressTo'     => $request->addressTo,
                    'price'         => $request->price,
                ]);

            });

            return apiResponse(201, 'success', 'delivery berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $id) {



        $rules = [
            'name'        => 'required',
            'addressFrom' => 'required',
            'addressTo'   => 'required',
            'price'       => 'required',


        ];

        $message = [
            'name.required'         => 'Mohon isikan nama agen kurir',
            'addressFrom.required'  => 'Mohon isikan daerah asal',
            'addressTo.required'    => 'Mohon isikan daerah tujuan',
            'price.required'        => 'Mohon isikan biaya pengantaran',


        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {

            if($request->has('photo')){
                $delivery = Delivery::where('id','=',$id)->first();
                $oldImage = $delivery->photo;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/delivery/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


            $extension = $request->file('photo')->getClientOriginalExtension();

            $deliveryPhoto = date('YmdHis').'.'.$extension;

            $path = base_path('public/photos/delivery/');

            $request->file('photo')->move($path, $deliveryPhoto);

            }


            DB::transaction(function () use ($request, $id, $deliveryPhoto) {

                Delivery::where('id', $id)->update([
                    'name'          => $request->name,
                    'photo'         => $deliveryPhoto,
                    'addressFrom'   => $request->addressFrom,
                    'addressTo'     => $request->addressTo,
                    'price'         => $request->price,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data delivery berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function delete($id) {
        $delivery = Delivery::where('id','=',$id)->first();
        $oldImage = $delivery->photo;

        if($oldImage){
            $pleaseRemove = base_path('public/photos/delivery/').$oldImage;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        try {
            DB::transaction(function () use ($id) {
                Delivery::where('id', $id)->delete();

            });

            return apiResponse(202, 'success', 'delivery berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
