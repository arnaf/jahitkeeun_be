<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterClientController extends Controller
{

    public function index()
    {

        $clients = DB::table('users')
                ->join('clients', 'users.id', '=', 'clients.user_id')
                ->select(['users.id as id', 'clients.id as client_id', 'users.name as client_name', 'clients.photo as client_photo', 'clients.phone as client_phone', 'clients.dateBirth as date_birth', 'clients.placeBirth as place_birth',])
                ->paginate();


        return apiResponse(200, 'success', 'List klien', $clients);

    }

    public function show($id) {
        $client = DB::table('users')
                ->join('clients', 'users.id', '=', 'clients.user_id')
                ->where('users.id', $id)
                ->select(['users.id as id', 'clients.id as client_id', 'users.name as client_name', 'clients.photo as client_photo', 'clients.phone as client_phone', 'clients.dateBirth as date_birth', 'clients.placeBirth as place_birth',])
                ->paginate();

        if($client) {
            return apiResponse(200, 'success', $client);
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
            'name.required'     => 'Mohon isikan nama klien',
            'email.required'    => 'Mohon isikan email klien',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password klien',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'     => 'Mohon isikan nomor handphone klien',
            'dateBirth.required' => 'Mohon isikan tanggal lahir klien',
            'placeBirth.required' => 'Mohon isikan tempat lahir klien',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {


            if($request->has('photo')){


                $extension = $request->file('photo')->getClientOriginalExtension();

                $clientPhoto = date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/client/');

                $request->file('photo')->move($path, $clientPhoto);

                }

            DB::transaction(function () use ($request, $clientPhoto) {
                $user = User::create([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => Hash::make($request->password),
                ]);

                Client::create([
                    'user_id'       => $user->id,
                    'photo'         => $clientPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'status'        => '1',
                ]);
                $user->assignRole('client');

            });

            return apiResponse(201, 'success', 'klien berhasil ditambahkan');
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
            'name.required'     => 'Mohon isikan nama klien',
            'email.required'    => 'Mohon isikan email klien',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password klien',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'     => 'Mohon isikan nomor handphone klien',
            'dateBirth.required' => 'Mohon isikan tanggal lahir klien',
            'placeBirth.required' => 'Mohon isikan tempat lahir klien',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {

            if($request->has('photo')){
                $userDetail = Client::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/client/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


            $extension = $request->file('photo')->getClientOriginalExtension();

            $clientPhoto = date('YmdHis').'.'.$extension;

            $path = base_path('public/photos/client/');

            $request->file('photo')->move($path, $clientPhoto);

            }


            DB::transaction(function () use ($request, $id, $clientPhoto) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                Client::where('user_id', $id)->update([
                    'photo'         => $clientPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data klien berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function destroy($id) {
        $userDetail = Client::where('user_id','=',$id)->first();
        $oldImage = $userDetail->photo;

        if($oldImage){
            $pleaseRemove = base_path('public/photos/client/').$oldImage;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        try {
            DB::transaction(function () use ($id) {
                Client::where('user_id', $id)->delete();
                User::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'user berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


}
