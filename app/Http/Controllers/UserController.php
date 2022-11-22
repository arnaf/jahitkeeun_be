<?php

namespace App\Http\Controllers;

use random;
use App\User;
use App\Admin;
use Exception;
use App\Client;
use App\Taylor;
use App\Convection;
use App\UserDetail;
use Illuminate\Support\Str;
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


        $rules = [
            'phone'         => 'required',
            'dateBirth'     => 'required',
            'placeBirth'    => 'required',

        ];

        $message = [

            'phone.required'    => 'Mohon isikan nomor hp anda',
            'dateBirth.required'  => 'Mohon isikan tanggal lahir anda',
            'placeBirth.required'  => 'Mohon isikan tempat lahir anda',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        $oldUser = User::where('id', $id)->first();
        $role = $oldUser->getRoleNames()[0];

        if($role == 'client') {
            if($request->has('photo')){

                $userDetail = Client::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo')->getClientOriginalExtension();

                $clientPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/';

                $request->file('photo')->move($path, $clientPhoto);
            }
        }else if($role == 'taylor') {
            if($request->has('photo')){

                $userDetail = Taylor::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }




                $extension = $request->file('photo')->getClientOriginalExtension();

                $taylorPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/';

                $request->file('photo')->move($path, $taylorPhoto);
            }
        } elseif($role == 'convection') {
            if($request->has('photo')){

                $userDetail = Convection::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo')->getClientOriginalExtension();

                $convectionPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/';

                $request->file('photo')->move($path, $convectionPhoto);
            }
        }  elseif($role == 'admin') {
            if($request->has('photo')){

                $userDetail = Admin::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo')->getClientOriginalExtension();

                $adminPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/';

                $request->file('photo')->move($path, $adminPhoto);
            }
        }

        try {



            if($role == 'taylor'){

                    DB::transaction(function () use($request, $id, $taylorPhoto) {

                        $user = Taylor::where('user_id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                            'photo'         => $taylorPhoto,
                            'phone'         => $request->phone,
                            'dateBirth'     => $request->dateBirth,
                            'placeBirth'    => $request->placeBirth,
                        ]);

                    });
            } elseif($role == 'convection'){


                    DB::transaction(function () use($request, $id, $convectionPhoto) {

                        $user = Taylor::where('user_id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                            'photo'         => $convectionPhoto,
                            'phone'         => $request->phone,
                            'dateBirth'     => $request->dateBirth,
                            'placeBirth'    => $request->placeBirth,
                        ]);

                    });
            } elseif($role == 'admin'){


                    DB::transaction(function () use($request, $id, $adminPhoto) {

                        $user = Admin::where('user_id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                            'photo'         => $adminPhoto,
                            'phone'         => $request->phone,
                            'dateBirth'     => $request->dateBirth,
                            'placeBirth'    => $request->placeBirth,
                        ]);


                    });
            }   elseif($role == 'client'){

                DB::transaction(function () use($request, $id, $clientPhoto) {

                    $user = Client::where('user_id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                            'photo'         => $clientPhoto,
                            'phone'         => $request->phone,
                            'dateBirth'     => $request->dateBirth,
                            'placeBirth'    => $request->placeBirth,
                        ]);


                });
            }



            return apiResponse(202, 'success', 'data pengguna berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function roleUpdateByID(Request $request, $id) {


        $rules = [
            'role'  => 'required',

        ];

        $message = [
            'role.required'    => 'Mohon isikan pilihan role',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Pilihan role belum diisi!', $validator->errors());
        }

        $role = $request->role;

        try {

            $role = $request->role;



            if($role == '2'){

                DB::transaction(function () use($id) {

                    $user = User::where('id', $id)->first();

                    $user->syncRoles('taylor');

                });
            } elseif($role == '3'){


                DB::transaction(function () use($id) {

                    $user = User::where('id', $id)->first();

                    $user->syncRoles('convection');

                });
            } elseif($role == '4'){

                DB::transaction(function () use($id) {

                    $user = User::where('id', $id)->first();

                    $user->syncRoles('admin');

                });
            }   elseif($role == '1'){

                DB::transaction(function () use($id) {

                    $user = User::where('id', $id)->first();

                    $user->syncRoles('client');

                });
            }



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
