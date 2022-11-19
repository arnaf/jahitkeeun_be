<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use Exception;
use App\Client;
use App\Taylor;
use App\Convection;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {

        $user = DB::table('users')->get();


        return apiResponse(200, 'success', 'List user', $user);
    }

    public function destroy($id) {
        try {
            DB::transaction(function () use ($id) {
              //User::where('id', $id)->delete();
                UserDetail::where('user_id', $id)->delete();
                User::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'user berhasil dihapus :(');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function show($id) {
        $user = User::where('id', $id)->first();

        if($user) {
            return apiResponse(200, 'success', 'data '.$user->name, $user->email);
        }

        return Response::json(apiResponse(404, 'not found', 'User tidak ditemukan :('), 404);
    }

    public function store(Request $request) {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',
            'address'   => 'required',
            'phone'     => 'required',
            'hobby'     => 'required',
        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password anda',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'address.required'  => 'Mohon isikan alamat anda',
            'phone.required'    => 'Mohon isikan nomor hp anda',
            'hobby.required'    => 'Mohon isikan hobi anda',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $id = User::insertGetId([
                    'name'  => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                UserDetail::insert([
                    'user_id'       => $id,
                    'address'       => $request->address,
                    'phone'         => $request->phone,
                    'hobby'         => $request->hobby,
                    'created_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(201, 'success', 'user berhasil daftar');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function profileUpdateByID(Request $request, $id) {

        $authRole = Auth::user()->getRoleNames()[0];

        if($request->has('photo')){
            if($authRole == 'client'){
                $userDetail = Client::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;
            } elseif($authRole == 'taylor'){
                $userDetail = Taylor::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;
            } elseif($authRole == 'convection'){
                $userDetail = Convection::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;
            } elseif($authRole == 'admin'){
                $userDetail = Admin::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;
            }


            if($oldImage){
                $pleaseRemove = base_path('public/photos/user/').$oldImage;

                if(file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }


            $extension = $request->file('photo')->getClientOriginalExtension();

            $clientPhoto = date('YmdHis').'.'.$extension;

            $path = base_path('public/photos/user/');

            $request->file('photo')->move($path, $clientPhoto);

        }

        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',

            'phone'         => 'required',
            'dateBirth'     => 'required',
            'placeBirth'    => 'required',

        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',

            'phone.required'    => 'Mohon isikan nomor hp anda',
            'dateBirth.required'  => 'Mohon isikan tanggal lahir anda',
            'placeBirth.required'  => 'Mohon isikan tempat lahir anda',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id, $clientPhoto, $authRole) {


                $user = User::where('id', $id)->first();
                $user->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);


                if($request->role == '2'){
                    $user->syncRoles('taylor');
                } elseif($request->role == '3') {
                    $user->syncRoles('convection');
                }


            });

            DB::transaction(function () use ($request, $id, $clientPhoto) {


                $authRoleNew = Auth::user()->getRoleNames();

                dd($authRoleNew);

                if($authRoleNew == 'client'){
                Client::where('user_id', $id)->update([
                    'photo'         => $clientPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
                } elseif($authRoleNew == 'taylor'){
                    Taylor::where('user_id', $id)->update([
                        'photo'         => $clientPhoto,
                        'phone'         => $request->phone,
                        'dateBirth'     => $request->dateBirth,
                        'placeBirth'    => $request->placeBirth,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                } elseif($authRoleNew == 'convection'){
                    Convection::where('user_id', $id)->update([
                        'photo'         => $clientPhoto,
                        'phone'         => $request->phone,
                        'dateBirth'     => $request->dateBirth,
                        'placeBirth'    => $request->placeBirth,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                } elseif($authRoleNew == 'admin'){
                    Admin::where('user_id', $id)->update([
                        'photo'         => $clientPhoto,
                        'phone'         => $request->phone,
                        'dateBirth'     => $request->dateBirth,
                        'placeBirth'    => $request->placeBirth,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                }


            });

            return apiResponse(202, 'success', 'data pengguna berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }













    public function passwordUpdateByID(Request $request, $id) {


        $rules = [
            // 'name'          => 'required',
            // 'email'         => 'required|email',
            'password'      => 'required|min:8'

        ];

        $message = [
            // 'name.required'     => 'Mohon isikan nama anda',
            // 'email.required'    => 'Mohon isikan email anda',
            // 'email.email'       => 'Mohon isikan email valid',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter'

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id) {


                $user = User::where('id', $id)->update([
                    // 'name'      => Auth::User()->name,
                    // 'email'     => Auth::User()->email,
                    'password'  => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);



            });

            return apiResponse(202, 'success', 'Password pengguna berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }




}
