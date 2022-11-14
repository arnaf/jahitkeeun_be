<?php

namespace App\Http\Controllers;


use App\Product;
use App\Stok;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::get();

        //$image = asset('assets/images/user/'.Auth::user()->detail->image);

        foreach ($product  as $produk) {



            $image = asset('assets/images/product/'.$produk->image);
            $data = [
                $produk,
                $image
            ];

        }

        //dd($Product);

        return apiResponse(200, 'success', 'List Product',$data);
    }

    public function destroy($id) {
        try {

            DB::transaction(function () use ($id) {
              Product::where('id', $id)->delete();

            });

            return apiResponse(202, 'success', 'Product berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function show($id) {
        $Product = Product::where('id', $id)->first();

        $data = [
            $Product
        ];

        if($Product) {
            return apiResponse(200, 'success', 'data '.$Product->name, $data);
        }

        return Response::json(apiResponse(404, 'not found', 'Product tidak ditemukan :('), 404);
    }

    public function store(Request $request) {
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
            'image'         => 'required',
            'barcode'       => 'required',
            'harga_beli'    => 'required',
            'price'         => 'required',
            'kategori_id'   => 'required'


        ];

        $message = [
            'name.required'        => 'Mohon isikan nama Product',
            'description.required'        => 'Mohon isikan description Product',
            'image.required'        => 'Mohon isikan image Product',
            'barcode.required'        => 'Mohon isikan barcode Product',
            'harga_beli.required'        => 'Mohon isikan harga beli Product',
            'price.required'        => 'Mohon isikan price Product',
            'kategori_id.required'        => 'Mohon isikan kategori Product',
            'team_id.required'        => 'Mohon isikan Cabang Product',

        ];

        $validator = Validator::make($request->all(), $rules, $message);



        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {

            $extension = $request->file('image')->getClientOriginalExtension();
            $image = date('YmdHis').'.'.$extension;
            $path = base_path('public/assets/images/product');
            $request->file('image')->move($path, $image);

            DB::transaction(function () use ($request,$image) {
                $product = Product::insertGetId([
                    'name'  => $request->name,
                    'description'  => $request->description,
                    'image'  => $image,
                    'barcode'  => $request->barcode,
                    'harga_beli'  => $request->harga_beli,
                    'price'  => $request->price,
                    'kategori_id'  => $request->kategori_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);



                Stok::insert([
                    'product_id'        => $product,
                    'current_stok'      => 0,
                    'team_id'           => $request->team_id,
                    'created_at'        => date('Y-m-d H:i:s')
                ]);




            });

            return apiResponse(201, 'success', 'Product berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function update(Request $request, $id) {
      $rules = [
          'name'         => 'required',


      ];

      $message = [
          'name.required'        => 'Mohon isikan nama Product',

      ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id) {
                Product::where('id', $id)->update([
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
