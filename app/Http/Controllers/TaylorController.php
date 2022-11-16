<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Taylor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TaylorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllTaylor() {
        //$user = User::where('name', $id)->first();
        $taylors = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->select([
                  'taylors.id as taylorId', 'users.name as taylorName', 'districts.name as districtName', 'taylors.rating as taylorRating', 'taylors.completedTrans as taylorComtrans', 'taylors.photo as taylorPhoto'
            ])
            ->get();



        if($taylors) {
            return apiResponse(200, 'success', 'list data taylor', $taylors);
        }

        return Response::json(apiResponse(404, 'not found', 'Taylor tidak ditemukan'), 404);
    }


    public function getTaylorByName($keyword) //Mencari data taylor search bar
    {



        $taylor = DB::table('users')
        ->join('taylors', 'users.id', '=', 'taylors.user_id')

        ->join('services', 'taylors.id', '=', 'services.taylor_id')
        ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
        ->where('users.name', 'like', '%'.$keyword.'%' )
        ->select([
            'users.id as userId', 'users.name as taylorName', 'service_categories.id as itemId', 'service_categories.name as itemName', 'taylors.photo as taylorPhoto', 'service_categories.photo as servicePhoto', 'services.price as servicePrice'
        ])
        ->limit(10)->get();



        if(count($taylor) > 0) {

            return apiResponse(200, 'success', 'list data penjahit', $taylor);

        } else if (count($taylor) < 1) {

            return Response::json(apiResponse(404, 'not found', 'Penjahit tidak ditemukan'), 404);

        }




    }



    public function getTaylorRatingAsc() {

        $user = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')

            ->select([
                  'users.id','users.name', 'districts.name as districtName', 'taylors.rating', 'taylors.completedTrans'
            ])

            ->orderBy('taylors.rating', 'asc');

            if(!$user == NULL) {
                $dataTaylor = [
                    'taylorId'          => $user->id,
                    'taylorName'        => $user->name,
                    'taylorLocation'    => $user->districtName,
                    'taylorRating'      => $user->rating,
                    'taylorComTrans'    => $user->completedTrans,

                ];
            }

        if($user) {
            return apiResponse(200, 'success', 'list data taylor', $dataTaylor);
        }

        return Response::json(apiResponse(404, 'not found', 'Taylor tidak ditemukan'), 404);
    }


    public function getTaylorRatingDesc() {

        $user = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')

            ->select([
                  'users.id','users.name', 'districts.name as districtName', 'taylors.rating', 'taylors.completedTrans'
            ])

            ->orderBy('taylors.rating', 'desc');

            if(!$user == NULL) {
                $dataTaylor = [
                    'taylorId'          => $user->id,
                    'taylorName'        => $user->name,
                    'taylorLocation'    => $user->districtName,
                    'taylorRating'      => $user->rating,
                    'taylorComTrans'    => $user->completedTrans,

                ];
            }

        if($user) {
            return apiResponse(200, 'success', 'list data taylor', $dataTaylor);
        }

        return Response::json(apiResponse(404, 'not found', 'Taylor tidak ditemukan'), 404);
    }



        // $reqsearch = $request->search;
        // $datas = User::role('client')
        // ->where('name' ,'like', $reqsearch)
        // ->get();
        // ->join('taylors', 'users.id', '=', 'taylors.user_id')
        // ->join('services', 'taylors.id', '=', 'services.taylor_id')
        // ->join('service_categories', 'services.id', '=', 'service_categories.service_id')
        // ->select(['users.name as taylorName', 'service_categories.name as itemName', 'service.name as serviceName', 'service.price as servicePrice'])
        // ->orderBy('taylors.name', 'asc');




        // $getItem = DB::table('service_categories')
        //            ->where($taylor->id, '=', 'taylor_id')
        //            ->select('service_categories.name');



        // $getService = DB::table('taylor_has_services')
        //               ->join('serivces', 'taylor_has_services.service_id', '=', 'services.id')
        //               ->join('taylors', 'taylor_has_services.taylor_id', '=', 'taylors.id')
        //               ->select([
        //                 'services.name as serviceName', 'services.price as servicePrice', 'taylors.name as taylorName', 'service.serviceCategory_id'
        //               ]);



    //     $data = [
    //         'caripenjahit' => 'tes',
    //         'name' => $datas,
    //         // 'item' => [

    //         //     // 'taylor_id' => $datas->taylorName,
    //         // ],
    //         'service' => [
    //             'name' => 'tes',
    //             // 'price' => $datas->servicePrice,
    //             // 'serviceCategory_id' => $datas->itemName,
    //         ]
    //      ];

    //      return apiResponse(200, 'success', 'List taylor', $data);

    //     } catch(Exception $e) {

    //         return apiResponse(400, 'error', 'error', $e);

    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Taylor  $taylor
     * @return \Illuminate\Http\Response
     */
    public function show(Taylor $taylor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Taylor  $taylor
     * @return \Illuminate\Http\Response
     */
    public function edit(Taylor $taylor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Taylor  $taylor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Taylor $taylor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Taylor  $taylor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taylor $taylor)
    {
        //
    }
}
