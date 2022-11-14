<?php

namespace App\Http\Controllers;


use App\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index()
    {
        $Team = Team::get();

        //dd($Team);

        return apiResponse(200, 'success', 'List Team', $Team);
    }

    public function destroy($id) {
        try {

            DB::transaction(function () use ($id) {
              Team::where('id', $id)->delete();

            });

            return apiResponse(202, 'success', 'Team berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function show($id) {
        $Team = Team::where('id', $id)->first();

        $data = [
            $Team
        ];

        if($Team) {
            return apiResponse(200, 'success', 'data '.$Team->name, $data);
        }

        return Response::json(apiResponse(404, 'not found', 'Team tidak ditemukan :('), 404);
    }

    public function store(Request $request) {
        $rules = [
            'name'         => 'required',


        ];

        $message = [
            'name.required'        => 'Mohon isikan nama Team',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $id = Team::insertGetId([
                    'name'  => $request->name,
                    'created_at' => date('Y-m-d H:i:s')
                ]);


            });

            return apiResponse(201, 'success', 'Team berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function update(Request $request, $id) {
      $rules = [
          'name'         => 'required',


      ];

      $message = [
          'name.required'        => 'Mohon isikan nama Team',

      ];

        $validator = Validator::make($request->all(), $rules, $message);


        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id) {
                Team::where('id', $id)->update([
                    'name'  => $request->name,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);





            });

            return apiResponse(202, 'success', 'Team berhasil dirubah');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }




}
