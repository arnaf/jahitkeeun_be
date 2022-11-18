<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Taylor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterTaylorController extends Controller
{
    public function index()
    {

        $taylors = DB::table('users')
                ->join('taylors', 'users.id', '=', 'taylors.user_id')
                ->select(['users.id as id', 'taylors.id as taylor_id', 'users.name as taylor_name', 'taylors.photo as taylor_photo', 'taylors.phone as taylor_phone', 'taylors.dateBirth as date_birth', 'taylors.placeBirth as place_birth',])
                ->paginate();


        return apiResponse(200, 'success', 'List penjahit', $taylors);

    }

    public function show($id) {
        $taylor = DB::table('users')
                ->join('taylors', 'users.id', '=', 'taylors.user_id')
                ->where('users.id', $id)
                ->select(['users.id as id', 'taylors.id as taylor_id', 'users.name as taylor_name', 'taylors.photo as taylor_photo', 'taylors.phone as taylor_phone', 'taylors.dateBirth as date_birth', 'taylors.placeBirth as place_birth',])
                ->paginate();

        if($taylor) {
            return apiResponse(200, 'success', $taylor);
        }

        return Response::json(apiResponse(404, 'not found', 'User tidak ditemukan'), 404);
    }


    public function create(Request $request) {



        $rules = [
            'name'       => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8',
            'phone'      => 'required',
            'dateBirth'  => 'required',
            'placeBirth' => 'required',


        ];

        $message = [
            'name.required'     => 'Mohon isikan nama penjahit',
            'email.required'    => 'Mohon isikan email penjahit',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password penjahit',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'     => 'Mohon isikan nomor handphone penjahit',
            'dateBirth.required' => 'Mohon isikan tanggal lahir penjahit',
            'placeBirth.required' => 'Mohon isikan tempat lahir penjahit',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {


            if($request->has('photo')){


                $extension = $request->file('photo')->getclientOriginalExtension();

                $taylorPhoto = date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/taylor/');

                $request->file('photo')->move($path, $taylorPhoto);

            }

            DB::transaction(function () use ($request, $taylorPhoto ) {
                $user = User::create([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => Hash::make($request->password),
                ]);

                Taylor::insert([
                    'user_id'       => $user->id,
                    'photo'         => $taylorPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'status'        => '1',
                    'rating'        => 0,
                    'completedTrans'=> 0,
                    'created_at'    => date('Y-m-d H:i:s')
                ]);
                $user->assignRole('taylor');

            });

            return apiResponse(201, 'success', 'penjahit berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $id) {



        $rules = [
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$id,
            'password'   => 'required|min:8',
            'phone'      => 'required',
            'dateBirth'  => 'required',
            'placeBirth' => 'required',
        ];

        $message = [
            'name.required'     => 'Mohon isikan nama penjahit',
            'email.required'    => 'Mohon isikan email penjahit',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password penjahit',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'     => 'Mohon isikan nomor handphone penjahit',
            'dateBirth.required' => 'Mohon isikan tanggal lahir penjahit',
            'placeBirth.required' => 'Mohon isikan tempat lahir penjahit',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {

            if($request->has('photo')){
                $userDetail = Taylor::where('user_id', '=', $id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/taylor/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


            $extension = $request->file('photo')->getclientOriginalExtension();

            $taylorPhoto = date('YmdHis').'.'.$extension;

            $path = base_path('public/photos/taylor/');

            $request->file('photo')->move($path, $taylorPhoto);

            }


            DB::transaction(function () use ($request, $id) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                Taylor::where('user_id', $id)->update([
                    // 'photo'         => $taylorPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,

                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data penjahit berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function delete($id) {
        $userDetail = Taylor::where('user_id','=',$id)->first();
        $oldImage = $userDetail->photo;

        if($oldImage){
            $pleaseRemove = base_path('public/photos/taylor/').$oldImage;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        try {
            DB::transaction(function () use ($id) {
                Taylor::where('user_id', $id)->delete();
                User::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'user berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
