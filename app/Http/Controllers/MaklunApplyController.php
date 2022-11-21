<?php

namespace App\Http\Controllers;

use Exception;
use App\MaklunApplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MaklunApplyController extends Controller
{


    public function create(Request $request, $maklunid, $userid) {
        $rules = [
            'bid'               => 'required',
            'desc'              => 'required',

        ];

        $message = [
            'bid.required'          => 'Mohon isikan jumlah bid',
            'desc.required'         => 'Mohon isikan deskripsi',

        ];

          $validator = Validator::make($request->all(), $rules, $message);

          if($validator->fails()) {
              return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
          }

          try {

           
              DB::transaction(function () use ($request, $userid, $maklunid) {
                $maklunApply = MaklunApplies::create([
                    'bid'           => $request->bid,
                    'desc'          => $request->desc,
                    'status'        => 'Apply',
                    'taylor_id'     => $userid,
                    'maklun_id'     => $maklunid,
                ]);
              });

              return apiResponse(202, 'success', 'Berhasil mengajukan pengerjaan maklun');
          } catch(Exception $e) {
              return apiResponse(400, 'error', 'error', $e);
          }
    }


    // public function destroy($id) {
    //     try {

    //         DB::transaction(function () use ($id) {
    //           Cart::where('user_id', $id)->delete();

    //         });

    //         return apiResponse(202, 'success', 'cart berhasil dikosongkan :(');
    //     } catch(Exception $e) {
    //         return apiResponse(400, 'error', 'error', $e);
    //     }
    // }
}
