<?php

namespace App\Http\Controllers;

use Exception;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterAddressController extends Controller
{
    public function index()
    {

            $data = DB::table('users')
                ->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('address_labels', 'addresses.addresslabel_id', '=', 'address_labels.id')
                ->join('provinces', 'addresses.province_id', '=', 'provinces.id')
                ->join('regencies', 'addresses.regency_id', '=', 'regencies.id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('villages', 'addresses.village_id', '=', 'villages.id')
                ->select(['users.id as user_id', 'addresses.id as address_id', 'address_labels.name as address_category', 'users.name as user_name', 'addresses.fullAddress as full_address', 'addresses.posCode as pos_code', 'provinces.name as province', 'regencies.name as regency', 'districts.name as district', 'villages.name as village'])
                ->orderBy('users.id', 'asc')
                ->paginate(20);


        return apiResponse(200, 'success', 'List klien', $data);

    }

    public function show($id) {
        $data = DB::table('users')
                ->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('address_labels', 'addresses.addresslabel_id', '=', 'address_labels.id')
                ->join('provinces', 'addresses.province_id', '=', 'provinces.id')
                ->join('regencies', 'addresses.regency_id', '=', 'regencies.id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('villages', 'addresses.village_id', '=', 'villages.id')
                ->select(['users.id as user_id', 'addresses.id as address_id', 'address_labels.name as address_category', 'users.name as user_name', 'addresses.fullAddress as full_address', 'addresses.posCode as pos_code', 'provinces.name as province', 'regencies.name as regency', 'districts.name as district', 'villages.name as village'])
                ->where('users.id', $id)
                ->orderBy('users.id', 'asc')
                ->paginate(20);

        if($data) {
            return apiResponse(200, 'success', $data);
        }

        return Response::json(apiResponse(404, 'not found', 'User tidak ditemukan'), 404);
    }

    public function create(Request $request) {



        $rules = [
            'user_id'           => 'required',
            'fullAddress'       => 'required',
            'posCode'           => 'required',
            'province_id'       => 'required',
            'regency_id'        => 'required',
            'district_id'       => 'required',
            'village_id'        => 'required',
            // 'lat'               => 'required',
            // 'long'              => 'required',
            'addresslabel_id'   => 'required',


        ];

        $message = [
            'user_id.required'          => 'Mohon pilih data pengguna',
            'fullAddress.required'      => 'Mohon isikan alamat lengkap',
            'posCode.required'          => 'Mohon isikan kode pos',
            'province_id.required'      => 'Mohon pilih provinsi',
            'regency_id.required'       => 'Mohon pilih kab/kota',
            'district_id.required'      => 'Mohon pilih kecamatan',
            'village_id.required'       => 'Mohon pilih desa/kelurahan',
            // 'lat.required'              => 'Mohon latitude',
            // 'long.required'             => 'Mohon longitude',
            'addresslabel_id.required'  => 'Mohon isikan tempat lahir klien',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {


            DB::transaction(function () use ($request) {
                $address = Address::create([
                    'user_id'          => $request->user_id,
                    'fullAddress'      => $request->fullAddress,
                    'posCode'          => $request->posCode,
                    'province_id'      => $request->province_id,
                    'regency_id'       => $request->regency_id,
                    'district_id'      => $request->district_id,
                    'village_id'       => $request->village_id,
                    'addresslabel_id'  => $request->addresslabel_id,

                ]);


            });

            return apiResponse(201, 'success', 'alamat berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $id) {



        $rules = [

            'fullAddress'       => 'required',
            'posCode'           => 'required',
            'province_id'       => 'required',
            'regency_id'        => 'required',
            'district_id'       => 'required',
            'village_id'        => 'required',
            // 'lat'               => 'required',
            // 'long'              => 'required',
            'addresslabel_id'   => 'required',


        ];

        $message = [

            'fullAddress.required'      => 'Mohon isikan alamat lengkap',
            'posCode.required'          => 'Mohon isikan kode pos',
            'province_id.required'      => 'Mohon pilih provinsi',
            'regency_id.required'       => 'Mohon pilih kab/kota',
            'district_id.required'      => 'Mohon pilih kecamatan',
            'village_id.required'       => 'Mohon pilih desa/kelurahan',
            // 'lat.required'              => 'Mohon latitude',
            // 'long.required'             => 'Mohon longitude',
            'addresslabel_id.required'  => 'Mohon isikan tempat lahir klien',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {


            DB::transaction(function () use ($request, $id) {
                Address::where('id', $id)->update([

                    'fullAddress'      => $request->fullAddress,
                    'posCode'          => $request->posCode,
                    'province_id'      => $request->province_id,
                    'regency_id'       => $request->regency_id,
                    'district_id'      => $request->district_id,
                    'village_id'       => $request->village_id,
                    'addresslabel_id'  => $request->addresslabel_id,
                    'updated_at'       => date('Y-m-d H:i:s')
                ]);

            });

            return apiResponse(202, 'success', 'data alamat user berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function delete($id) {

        try {
            DB::transaction(function () use ($id) {
                Address::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'alamat berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


}
