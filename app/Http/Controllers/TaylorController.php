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
    public function getAll()
    {
        try {
            $taylor = Taylor::get();

            return apiResponse(200, 'success', 'List taylor', $taylor);

        } catch(Exception $e) {

            return apiResponse(400, 'error', 'error', $e);

        }

    }

    public function getTaylor($name)
    {

        try{
            $user = DB::table('users')
            ->join('taylors', 'users.id', '=', 'taylors.user_id')
            ->join('addresses', 'users.id', '=', 'addresses.user_id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->where('name', 'like', '%'.$name.'%' )
            // ->join('address_labels', 'addresses.addresslabel_id', '=', 'address_labels.id')
            ->select([
                'districts.name as districtName', 'users.name as userName'
            ])
            // ->select([
            //     'users.id as userId', 'users.name as userName', 'districts.name as districtName', 'taylors.rating as taylorRating', 'taylors.completedTrans'
            // ]);
            ->first();


            // $service = DB::table('taylors')
            // ->where($user->id, 'user_id')
            // ->first();

            // $category = DB::table('service_categories')







                $dataTaylor = [
                    'id'          => $user->user_id,
                    'nama taylor' => $user->userName,
                    'location'    => $user->districtName,
                    // 'rating'      => $user->rating,
                    // 'completed transaction'  => $user->photo,

                ];



            return apiResponse(200, 'success', 'List taylor', $dataTaylor);

            // return response()->json(['meta' => $meta, 'data taylor' => $dataTaylor, 'item' => $dataItem, 'service' => $dataService], 200);
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'taylor tidak dapat ditemukan', $e);
        }




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
