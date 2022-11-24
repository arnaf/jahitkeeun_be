<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class WilayahController extends Controller
{
    public function getAllProvince()
    {

        $provinces = DB::table('provinces')
                ->select(['provinces.id as province_id', 'provinces.name as province_name'])
                ->get();


                if(count($provinces) > 0) {
                    return apiResponse(200, 'success', 'List provinsi', $provinces);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data provinsi tidak ditemukan'), 404);
                }
    }

    public function getRegencyByProvinceId($id)
    {

        $regencies = DB::table('regencies')
                ->where('province_id', $id)
                ->select(['regencies.id as regency_id', 'regencies.name as regency_name'])
                ->get();


                if(count($regencies) > 0) {
                    return apiResponse(200, 'success', 'List kabupaten/kota', $regencies);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data kabupaten/kota tidak ditemukan'), 404);
                }
    }

    public function getDistrictByRegencyId($id)
    {

        $districts = DB::table('districts')
                ->where('regency_id', $id)
                ->select(['districts.id as district_id', 'districts.name as district_name'])
                ->get();


                if(count($districts) > 0) {
                    return apiResponse(200, 'success', 'List kecamatan', $districts);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data kecamatan tidak ditemukan'), 404);
                }
    }


    public function getVillageByDistrictId($id)
    {

        $villages = DB::table('villages')
                ->where('district_id', $id)
                ->select(['villages.id as village_id', 'villages.name as village_name'])
                ->get();


                if(count($villages) > 0) {
                    return apiResponse(200, 'success', 'List desa/kelurahan', $villages);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data desa/kelurahan tidak ditemukan'), 404);
                }
    }


}
