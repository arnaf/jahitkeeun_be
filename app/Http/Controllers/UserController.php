<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Exception;
use App\Taylor;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {

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


    public function clientProfileUpdate(Request $request, $id) {



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

        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            // 'password'   => 'required|min:8',
            'phone'         => 'required',
            'dateBirth'     => 'required',
            'placeBirth'    => 'required',

        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            // 'password.required' => 'Mohon isikan password anda',
            // 'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'    => 'Mohon isikan nomor hp anda',
            'dateBirth.required'  => 'Mohon isikan tanggal lahir anda',
            'placeBirth.required'  => 'Mohon isikan tempat lahir anda',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id, $clientPhoto) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    // 'password' => Hash::make($request->password),
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

            return apiResponse(202, 'success', 'data user berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function taylorProfileUpdate(Request $request, $id) {



        if($request->has('photo')){
            $userDetail = Taylor::where('user_id','=',$id)->first();
            $oldImage = $userDetail->photo;

            if($oldImage){
                $pleaseRemove = base_path('public/photos/taylor/').$oldImage;

                if(file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }


        $extension = $request->file('photo')->getClientOriginalExtension();

        $taylorPhoto = date('YmdHis').'.'.$extension;

        $path = base_path('public/photos/taylor/');

        $request->file('photo')->move($path, $taylorPhoto);

        }

        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            // 'password'   => 'required|min:8',
            'phone'         => 'required',
            'dateBirth'     => 'required',
            'placeBirth'    => 'required',

        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            // 'password.required' => 'Mohon isikan password anda',
            // 'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'    => 'Mohon isikan nomor hp anda',
            'dateBirth.required'  => 'Mohon isikan tanggal lahir anda',
            'placeBirth.required'  => 'Mohon isikan tempat lahir anda',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id, $taylorPhoto) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    // 'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                Taylor::where('user_id', $id)->update([

                    'photo'         => $taylorPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data user berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


    public function convectionProfileUpdate(Request $request, $id) {



        if($request->has('photo')){
            $userDetail = Convection::where('user_id','=',$id)->first();
            $oldImage = $userDetail->photo;

            if($oldImage){
                $pleaseRemove = base_path('public/photos/convection/').$oldImage;

                if(file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }


        $extension = $request->file('photo')->getClientOriginalExtension();

        $convectionPhoto = date('YmdHis').'.'.$extension;

        $path = base_path('public/photos/convection/');

        $request->file('photo')->move($path, $convectionPhoto);

        }

        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            // 'password'   => 'required|min:8',
            'phone'         => 'required',
            'dateBirth'     => 'required',
            'placeBirth'    => 'required',

        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            // 'password.required' => 'Mohon isikan password anda',
            // 'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'    => 'Mohon isikan nomor hp anda',
            'dateBirth.required'  => 'Mohon isikan tanggal lahir anda',
            'placeBirth.required'  => 'Mohon isikan tempat lahir anda',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id, $convectionPhoto) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    // 'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                Taylor::where('user_id', $id)->update([

                    'photo'         => $convectionPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data user berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function adminProfileUpdate(Request $request, $id) {



        if($request->has('photo')){
            $userDetail = Admin::where('user_id','=',$id)->first();
            $oldImage = $userDetail->photo;

            if($oldImage){
                $pleaseRemove = base_path('public/photos/admin/').$oldImage;

                if(file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }
            }


        $extension = $request->file('photo')->getClientOriginalExtension();

        $adminPhoto = date('YmdHis').'.'.$extension;

        $path = base_path('public/photos/admin/');

        $request->file('photo')->move($path, $adminPhoto);

        }

        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            // 'password'   => 'required|min:8',
            'phone'         => 'required',
            'dateBirth'     => 'required',
            'placeBirth'    => 'required',

        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            // 'password.required' => 'Mohon isikan password anda',
            // 'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'    => 'Mohon isikan nomor hp anda',
            'dateBirth.required'  => 'Mohon isikan tanggal lahir anda',
            'placeBirth.required'  => 'Mohon isikan tempat lahir anda',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request, $id, $adminPhoto) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    // 'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                Taylor::where('user_id', $id)->update([

                    'photo'         => $adminPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data user berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }


}
