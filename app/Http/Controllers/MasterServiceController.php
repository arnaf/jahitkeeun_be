<?php

namespace App\Http\Controllers;

use Exception;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterServiceController extends Controller
{
    public function index()
    {

        $services = DB::table('services')
                ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
                ->join('taylors', 'services.taylor_id', '=', 'taylors.id')
                ->join('users', 'taylors.user_id', '=', 'users.id')
                ->select(['services.id', 'services.name as service_name', 'services.price as service_price', 'users.name as taylor_name', 'service_categories.name as service_category_name',])
                ->orderBy('services.id', 'asc')
                ->paginate();


        return apiResponse(200, 'success', 'List jasa', $services);

    }

    public function show($id) {
        $services = DB::table('services')
                    ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
                    ->join('taylors', 'services.taylor_id', '=', 'taylors.id')
                    ->join('users', 'taylors.user_id', '=', 'users.id')
                    ->select(['services.name as service_name', 'services.price as service_price', 'users.name as taylor_name', 'service_categories.name as service_category_name',])
                    ->where('services.id', $id)
                    ->paginate();

        if($services) {
            return apiResponse(200, 'success', $services);
        }

        return Response::json(apiResponse(404, 'not found', 'Jasa tidak ditemukan'), 404);
    }


    public function create(Request $request) {



        $rules = [
            'name'                  => 'required',
            'price'                 => 'required',
            'service_categories_id' => 'required',
            'taylor_id'             => 'required',


        ];

        $message = [
            'name.required'                     => 'Mohon isikan nama jasa',
            'price.required'                    => 'Mohon isikan harga jasa',
            'service_categories_id.required'    => 'Mohon isikan kategori jasa',
            'taylor_id.required'                => 'Mohon masukan data penjahit',


        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {


            DB::transaction(function () use ($request) {
                $service = Service::create([
                    'name'                      => $request->name,
                    'price'                     => $request->price,
                    'service_categories_id'     => $request->service_categories_id,
                    'taylor_id'                 => $request->taylor_id,
                ]);

            });

            return apiResponse(201, 'success', 'Jasa berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $id) {



        $rules = [
            'name'                  => 'required',
            'price'                 => 'required',
            'service_categories_id' => 'required',
            'taylor_id'             => 'required',


        ];

        $message = [
            'name.required'                     => 'Mohon isikan nama jasa',
            'price.required'                    => 'Mohon isikan harga jasa',
            'service_categories_id.required'    => 'Mohon isikan kategori jasa',
            'taylor_id.required'                => 'Mohon masukan data penjahit',


        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {



            DB::transaction(function () use ($request, $id) {

                Service::where('id', $id)->update([
                    'name'                      => $request->name,
                    'price'                     => $request->price,
                    'service_categories_id'     => $request->service_categories_id,
                    'taylor_id'                 => $request->taylor_id,
                    'updated_at'                => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data jasa berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function delete($id) {

        try {
            DB::transaction(function () use ($id) {
                Service::where('id', $id)->delete();

            });

            return apiResponse(202, 'success', 'data jasa berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
