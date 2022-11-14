<?php

namespace App\Http\Controllers;


use App\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::get();

        //dd($brand);

        return apiResponse(200, 'success', 'List brand', $brand);
    }

    public function destroy($id) {
        try {

            DB::transaction(function () use ($id) {
              Brand::where('id', $id)->delete();
                //UserDetail::where('user_id', $id)->delete();
                //User::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'brand berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function show($id) {
        $brand = Brand::where('id', $id)->first();

        if($brand) {
            return apiResponse(200, 'success', 'data '.$brand->title, $brand->status);
        }

        return Response::json(apiResponse(404, 'not found', 'Brand tidak ditemukan :('), 404);
    }

    public function store(Request $request) {
        $rules = [
            'title'         => 'required',
            'slug'          => 'required',
            'status'        => 'required',

        ];

        $message = [
            'title.required'        => 'Mohon isikan title anda',
            'slug.required'         => 'Mohon isikan slug anda',
            'status.required'       => 'Mohon isikan status anda',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $id = Brand::insertGetId([
                    'title'  => $request->title,
                    'slug' => $request->slug,
                    'status' => $request->status,
                    'created_at' => date('Y-m-d H:i:s')
                ]);


            });

            return apiResponse(201, 'success', 'brand berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function update(Request $request, $id) {
      $rules = [
          'title'         => 'required',
          'slug'          => 'required',
          'status'        => 'required',

      ];

      $message = [
          'title.required'        => 'Mohon isikan title anda',
          'slug.required'         => 'Mohon isikan slug anda',
          'status.required'       => 'Mohon isikan status anda',
      ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id) {
                Brand::where('id', $id)->update([
                    'title'  => $request->title,
                    'slug' => $request->slug,
                    'status' => $request->status,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);


            });

            return apiResponse(202, 'success', 'brand berhasil dirubah');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }




}
