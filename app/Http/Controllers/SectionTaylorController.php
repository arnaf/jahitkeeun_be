<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SectionTaylorController extends Controller
{

    public function getAllTaylor() {

        $taylors = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->select([
                  'taylors.id as taylorId', 'users.name as taylorName', 'districts.name as districtName', 'taylors.rating as taylorRating', 'taylors.completedTrans as taylorComtrans', 'taylors.photo as taylorPhoto'
            ])
            ->get();



        if(count($taylors) > 0) {
            return apiResponse(200, 'success', 'list data taylor', $taylors);
        } else {

            return Response::json(apiResponse(404, 'not found', 'Taylor tidak ditemukan'), 404);

        }

    }

    public function getTaylorByTaylorId($id) {
        $taylor = DB::table('users')
                ->join('taylors', 'users.id', '=', 'taylors.user_id')
                ->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->where('taylors.id', $id)
                ->select(['taylors.id as taylor_id', 'users.name as taylor_name', 'taylors.photo as taylor_photo', 'taylors.rating', 'taylors.completedTrans as completed_transaction', 'taylors.phone as taylor_phone', 'taylors.dateBirth as date_birth', 'taylors.placeBirth as place_birth', 'districts.name as districtName',])
                ->paginate();

        if($taylor) {
            return apiResponse(200, 'success', $taylor);
        }

        return Response::json(apiResponse(404, 'not found', 'Taylor tidak ditemukan'), 404);
    }


    public function getTaylorByRating($i) {

        $nilai = $i;

        if($nilai == '1') {
        $user = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')

            ->select([
                'users.id','users.name', 'districts.name as districtName', 'taylors.rating', 'taylors.completedTrans'
                ])
            ->orderBy('taylors.rating', 'desc')
            ->paginate();


                return apiResponse(200, 'success', 'list data taylor', $user);

            } elseif($nilai == '0') {
                $user = DB::table('users')
                ->join('taylors', 'users.id', '=', 'taylors.user_id')
                ->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->select([
                    'users.id','users.name', 'districts.name as districtName', 'taylors.rating', 'taylors.completedTrans'
                ])
                ->orderBy('taylors.rating', 'asc')
                ->paginate();

                return apiResponse(200, 'success', 'list data taylor', $user);
            } else {

                return Response::json(apiResponse(404, 'not found', 'Taylor tidak ditemukan'), 404);

            }

    }


    public function getTaylorByPrice($i) {

        $nilai = $i;

        if($nilai == '1') {
        $user = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('services', 'taylors.id', '=', 'services.taylor_id')
            ->select([
                  'users.id','users.name', 'districts.name as districtName', 'taylors.rating', 'services.price as servicePrice'
            ])
            ->orderBy('services.price', 'desc')
            ->paginate();


                return apiResponse(200, 'success', 'list data taylor berdasarkan harga jasa', $user);

            } elseif($nilai == '0') {
                $user = DB::table('users')
                ->join('taylors', 'users.id', '=', 'taylors.user_id')
                ->join('addresses', 'users.id', '=', 'addresses.user_id')
                ->join('districts', 'addresses.district_id', '=', 'districts.id')
                ->join('services', 'taylors.id', '=', 'services.taylor_id')
                ->select([
                      'users.id','users.name', 'districts.name as districtName', 'taylors.rating', 'services.price as servicePrice'
                ])
                ->orderBy('services.price', 'asc')
                ->paginate();

                return apiResponse(200, 'success', 'list data taylor berdasarkan harga jasa', $user);
            } else {

                return Response::json(apiResponse(404, 'not found', 'Data tidak ditemukan'), 404);
            }

    }


    public function getTaylorByRegency($keyword) {


        $user = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('regencies', 'addresses.regency_id', '=', 'regencies.id')
            ->where('regencies.name', 'LIKE', '%'.$keyword.'%')
            ->select([
                  'users.id', 'users.name', 'regencies.name as regencyName', 'taylors.rating',
            ])
            ->orderBy('regencies.name', 'desc')
            ->paginate();

            $count_user = $user->total();

            if($count_user >= 1) {

                return apiResponse(200, 'success', 'list data taylor', $user);

            } elseif ($count_user < 1){

                return Response::json(apiResponse(404, 'not found', 'Data tidak ditemukan'), 404);

            }



    }



}
