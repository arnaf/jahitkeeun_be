<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RefAlamatController extends Controller
{
    public function getAllAddressBandung()
    {

        $wilayah = DB::table('regencies')
                ->join('districts', 'regencies.id', '=', 'districts.regency_id')
                ->whereIn('regencies.id', ['3217', '3273', '3204'])
                ->select(['regencies.id as regency_id', 'regencies.name as regency_name', 'districts.id as district_id', 'districts.name as district_name'])
                ->paginate(100);


        return apiResponse(200, 'success', 'List penjahit', $wilayah);

    }
}
