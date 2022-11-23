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
    // public function index() {

    //     $user = DB::table('users')->get();


    //     return apiResponse(200, 'success', 'List user', $user);
    // }

    // public function destroy($id) {
    //     try {
    //         DB::transaction(function () use ($id) {
    //           //User::where('id', $id)->delete();
    //             UserDetail::where('user_id', $id)->delete();
    //             User::where('id', $id)->delete();
    //         });

    //         return apiResponse(202, 'success', 'user berhasil dihapus :(');
    //     } catch(Exception $e) {
    //         return apiResponse(400, 'error', 'error', $e);
    //     }
    // }

    // public function show($id) {
    //     $user = User::where('id', $id)->first();

    //     if($user) {
    //         return apiResponse(200, 'success', 'data '.$user->name, $user->email);
    //     }

    //     return Response::json(apiResponse(404, 'not found', 'User tidak ditemukan :('), 404);
    // }

    // public function store(Request $request) {
    //     $rules = [
    //         'name'      => 'required',
    //         'email'     => 'required|email|unique:users',
    //         'password'  => 'required|min:8',
    //         'address'   => 'required',
    //         'phone'     => 'required',
    //         'hobby'     => 'required',
    //     ];

    //     $message = [
    //         'name.required'     => 'Mohon isikan nama anda',
    //         'email.required'    => 'Mohon isikan email anda',
    //         'email.email'       => 'Mohon isikan email valid',
    //         'email.unique'      => 'Email sudah terdaftar',
    //         'password.required' => 'Mohon isikan password anda',
    //         'password.min'      => 'Password wajib mengandung minimal 8 karakter',
    //         'address.required'  => 'Mohon isikan alamat anda',
    //         'phone.required'    => 'Mohon isikan nomor hp anda',
    //         'hobby.required'    => 'Mohon isikan hobi anda',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $message);

    //     if($validator->fails()) {
    //         return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
    //     }

    //     try {
    //         DB::transaction(function () use ($request) {
    //             $id = User::insertGetId([
    //                 'name'  => $request->name,
    //                 'email' => $request->email,
    //                 'password' => Hash::make($request->password),
    //                 'created_at' => date('Y-m-d H:i:s')
    //             ]);

    //             UserDetail::insert([
    //                 'user_id'       => $id,
    //                 'address'       => $request->address,
    //                 'phone'         => $request->phone,
    //                 'hobby'         => $request->hobby,
    //                 'created_at'    => date('Y-m-d H:i:s')
    //             ]);
    //         });

    //         return apiResponse(201, 'success', 'user berhasil daftar');
    //     } catch(Exception $e) {
    //         return apiResponse(400, 'error', 'error', $e);
    //     }
    // }







    public function profileUpdateByID(Request $request, $id) {


        // $rules = [


        // ];

        // $message = [



        // ];

        // $validator = Validator::make($request->all(), $rules, $message);

        // if($validator->fails()) {
        //     return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        // }

        $oldUser = User::where('id', $id)->first();
        $role = $oldUser->getRoleNames()[0];

        $clientPhoto = null;
        $taylorPhoto = null;
        $convectionPhoto = null;
        $adminPhoto = null;


        if($role == 'client') {

            if($request->hasFile('photo')){

                $userDetail = Client::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/'.$oldImage;
                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo')->getClientOriginalExtension();

                $clientPhoto = '1'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/';

                $request->file('photo')->move($path, $clientPhoto);
            }
        }else if($role == 'taylor') {
            if($request->hasFile('photo')){

                $userDetail = Taylor::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }




                $extension = $request->file('photo')->getClientOriginalExtension();

                $taylorPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/';

                $request->file('photo')->move($path, $taylorPhoto);
            }
        } elseif($role == 'convection') {
            if($request->hasFile('photo')){

                $userDetail = Convection::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo')->getClientOriginalExtension();

                $convectionPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/';

                $request->file('photo')->move($path, $convectionPhoto);
            }
        }  elseif($role == 'admin') {
            if($request->hasFile('photo')){

                $userDetail = Admin::where('user_id','=',$id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo')->getClientOriginalExtension();

                $adminPhoto = date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-user/';

                $request->file('photo')->move($path, $adminPhoto);
            }
        }

        try {



            if($role == 'taylor'){

                    DB::transaction(function () use($request, $id, $taylorPhoto) {

                        $taylor = Taylor::where('user_id', $id)->first();
                        $user = User::where('id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                        ]);

                        $taylor->update([

                            'photo'         => $taylorPhoto,
                            'phone'         => $request->phone,
                            'dateBirth'     => $request->dateBirth,
                            'placeBirth'    => $request->placeBirth,
                        ]);

                    });
            } elseif($role == 'convection'){


                    DB::transaction(function () use($request, $id, $convectionPhoto) {

                        $convection = Taylor::where('user_id', $id)->first();
                        $user = User::where('id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                        ]);

                        $convection->update([
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

                        $admin = Admin::where('user_id', $id)->first();
                        $user = User::where('id', $id)->first();

                        $user->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                        ]);

                        $admin->update([
                            'email'         => $request->email,
                            'name'          => $request->name,
                            'photo'         => $adminPhoto,
                            'phone'         => $request->phone,
                            'dateBirth'     => $request->dateBirth,
                            'placeBirth'    => $request->placeBirth,
                        ]);


                    });
            } else if($role == 'client'){

                DB::transaction(function () use($request, $id, $clientPhoto) {



                    $client = Client::where('user_id', $id)->first();
                    $user = User::where('id', $id)->first();

                    $oldUser = User::where('id', $id)->first();
                    $oldClient = Client::where('user_id', $id)->first();


                    $user->update([
                        'email'         => $request->email ?: $oldUser->email,
                        'name'          => $request->name ?: $oldUser->name,
                    ]);


                        $client->update([
                            'photo'         => $clientPhoto ?: $oldClient->photo,
                            'phone'         => $request->phone ?: $oldClient->phone,
                            'dateBirth'     => $request->dateBirth ?: $oldClient->dateBirth,
                            'placeBirth'    => $request->placeBirth ?: $oldClient->placeBirth,
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

        $oldUser = User::where('id', $id)->first();
        $oldRole = $oldUser->getRoleNames()[0];

        if($oldRole == 'client') {

            $oldUserDatas = Client::where('user_id', '=', $id)->first();

            $oldUserDetail = [
                'photo' => $oldUserDatas->photo,
                'phone' => $oldUserDatas->phone,
                'dateBirth' => $oldUserDatas->dateBirth,
                'placeBirth' => $oldUserDatas->placeBirth,
            ];

            DB::transaction(function () use($id) {

                Client::where('user_id', $id)->delete();

            });
        } elseif($oldRole == 'taylor') {
            $oldUserDatas = Taylor::where('user_id', '=', $id)->first();
            $oldUserDetail = [
                'photo' => $oldUserDatas->photo,
                'phone' => $oldUserDatas->phone,
                'dateBirth' => $oldUserDatas->dateBirth,
                'placeBirth' => $oldUserDatas->placeBirth,
                'rating'     => $oldUserDatas->rating,
                'completedTrans'     => $oldUserDatas->completedTrans,
            ];

            DB::transaction(function () use($id) {

                Taylor::where('user_id', $id)->delete();

            });
        } elseif($oldRole == 'convection') {
            $oldUserDatas = Convection::where('user_id', '=', $id)->first();
            $oldUserDetail = [
                'photo' => $oldUserDatas->photo,
                'phone' => $oldUserDatas->phone,
                'dateBirth' => $oldUserDatas->dateBirth,
                'placeBirth' => $oldUserDatas->placeBirth,
            ];

            DB::transaction(function () use($id) {

                Convection::where('user_id', $id)->delete();

            });
        }





        try {

            $role = $request->role;



            if($role == '2'){

                DB::transaction(function () use($id, $oldUserDetail) {

                    $user = User::where('id', $id)->first();
                    Taylor::create([
                        'user_id'           => $user->id,
                        'photo'             => $oldUserDetail['photo'],
                        'phone'             => $oldUserDetail['phone'],
                        'dateBirth'         => $oldUserDetail['dateBirth'],
                        'placeBirth'        => $oldUserDetail['placeBirth'],
                        'rating'            => 0,
                        'completedTrans'    => 0,
                        'status'            => '1',
                    ]);

                    $user->syncRoles('taylor');

                });
            } elseif($role == '3'){


                DB::transaction(function () use($id, $oldUserDetail) {

                    $user = User::where('id', $id)->first();
                    Convection::create([
                        'user_id'           => $user->id,
                        'photo'             => $oldUserDetail['photo'],
                        'phone'             => $oldUserDetail['phone'],
                        'dateBirth'         => $oldUserDetail['dateBirth'],
                        'placeBirth'        => $oldUserDetail['placeBirth'],
                        'status'            => '1',
                    ]);

                    $user->syncRoles('convection');

                });
            }   elseif($role == '1'){

                DB::transaction(function () use($id, $oldUserDetail) {

                    $user = User::where('id', $id)->first();

                    Client::create([
                        'user_id'       => $user->id,
                        'photo'         => $oldUserDetail['photo'],
                        'phone'         => $oldUserDetail['phone'],
                        'dateBirth'     => $oldUserDetail['dateBirth'],
                        'placeBirth'    => $oldUserDetail['placeBirth'],
                        'status'        => '1',
                    ]);

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
