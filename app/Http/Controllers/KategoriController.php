<?php

namespace App\Http\Controllers;


use App\kategori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::get();

        //dd($kategori);

        return apiResponse(200, 'success', 'List kategori', $kategori);
    }

    public function destroy($id) {
        try {

            DB::transaction(function () use ($id) {
              kategori::where('id', $id)->delete();

            });

            return apiResponse(202, 'success', 'kategori berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function show($id) {
        $kategori = kategori::where('id', $id)->first();

        $data = [
            $kategori
        ];

        if($kategori) {
            return apiResponse(200, 'success', 'data '.$kategori->name, $data);
        }

        return Response::json(apiResponse(404, 'not found', 'kategori tidak ditemukan :('), 404);
    }

    public function store(Request $request) {
        $rules = [
            'name'         => 'required',


        ];

        $message = [
            'name.required'        => 'Mohon isikan nama kategori',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $id = kategori::insertGetId([
                    'name'  => $request->name,
                    'created_at' => date('Y-m-d H:i:s')
                ]);


            });

            return apiResponse(201, 'success', 'Kategori berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function update(Request $request, $id) {
      $rules = [
          'name'         => 'required',


      ];

      $message = [
          'name.required'        => 'Mohon isikan nama kategori',

      ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id) {
                kategori::where('id', $id)->update([
                    'name'  => $request->name,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);


            });

            return apiResponse(202, 'success', 'Kategori berhasil dirubah');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }




}
