<?php

namespace App\Http\Controllers;

use Exception;
use App\Maklun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterMaklunController extends Controller
{
    public function index()
    {

        $makluns = DB::table('makluns')
                    ->join('users', 'makluns.maklun_maker_id', '=', 'users.id')
                    ->select(['makluns.id as id', 'users.id as maklun_maker_id', 'users.name as maklun_maker_name', 'makluns.title as maklun_title', 'makluns.price as maklun_price', 'makluns.dueTime as maklun_due_time', 'makluns.status as maklun_status'])
                    ->paginate();


        return apiResponse(200, 'success', 'List maklun', $makluns);

    }

    public function showByMaklun($id) {
        $makluns = DB::table('makluns')
                    ->join('users', 'makluns.maklun_maker_id', '=', 'users.id')
                    ->join('addresses', 'users.id', '=', 'addresses.id')
                    ->join('districts', 'addresses.district_id', '=', 'districts.id')
                    ->select(['makluns.id as id', 'users.id as maklun_maker_id', 'users.name as maklun_maker_name', 'districts.name as maklun_maker_loc', 'makluns.title as maklun_title', 'makluns.price as maklun_price', 'makluns.dueTime as maklun_due_time', 'makluns.status as maklun_status'])
                    ->where('makluns.id', $id)
                    ->paginate();

        if($makluns) {
            return apiResponse(200, 'success', $makluns);
        }

        return Response::json(apiResponse(404, 'not found', 'Maklun tidak ditemukan'), 404);
    }


    public function showByUser($id) {
        $makluns = DB::table('makluns')
                    ->join('users', 'makluns.maklun_maker_id', '=', 'users.id')
                    ->join('addresses', 'users.id', '=', 'addresses.id')
                    ->join('districts', 'addresses.district_id', '=', 'districts.id')
                    ->select(['makluns.id as id', 'users.id as maklun_maker_id', 'users.name as maklun_maker_name', 'districts.name as maklun_maker_loc', 'makluns.title as maklun_title', 'makluns.price as maklun_price', 'makluns.dueTime as maklun_due_time', 'makluns.status as maklun_status'])
                    ->where('users.id', $id)
                    ->paginate();

        if($makluns) {
            return apiResponse(200, 'success', $makluns);
        }

        return Response::json(apiResponse(404, 'not found', 'Maklun tidak ditemukan'), 404);
    }


    public function create(Request $request) {



        $rules = [
            'title'             => 'required',
            'desc'              => 'required',
            'price'             => 'required',
            'dueTime'           => 'required',
            'maklun_maker_id'   => 'required'


        ];

        $message = [
            'title.required'         => 'Mohon isikan judul maklun',
            'desc.required'          => 'Mohon isikan deskripsi maklun',
            'price.required'         => 'Mohon isikan price maklun',
            'dueTime.required'       => 'Mohon isikan waktu berakhir maklun',
            'maklun_maker_id'        => 'Mohon isikan pembuat maklun'

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {



            DB::transaction(function () use ($request) {
                $maklun = Maklun::create([
                    'title'             => $request->title,
                    'desc'              => $request->desc,
                    'price'             => $request->price,
                    'dueTime'           => $request->dueTime,
                    'maklun_maker_id'   => $request->maklun_maker_id,
                    'status'            => '1',
                ]);

            });

            return apiResponse(201, 'success', 'Maklun berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $id) {



        $rules = [
            'title'             => 'required',
            'desc'              => 'required',
            'price'             => 'required',
            'dueTime'           => 'required',
            'maklun_maker_id'   => 'required'


        ];

        $message = [
            'title.required'         => 'Mohon isikan judul maklun',
            'desc.required'          => 'Mohon isikan deskripsi maklun',
            'price.required'         => 'Mohon isikan price maklun',
            'dueTime.required'       => 'Mohon isikan waktu berakhir maklun',
            'maklun_maker_id'        => 'Mohon isikan pembuat maklun'

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {

            DB::transaction(function () use ($request, $id) {

                Maklun::where('id', $id)->update([
                    'title'             => $request->title,
                    'desc'              => $request->desc,
                    'price'             => $request->price,
                    'dueTime'           => $request->dueTime,
                    'maklun_maker_id'   => $request->maklun_maker_id,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data maklun berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function delete($id) {

        try {
            DB::transaction(function () use ($id) {
                Maklun::where('id', $id)->delete();

            });

            return apiResponse(202, 'success', 'Maklun berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
