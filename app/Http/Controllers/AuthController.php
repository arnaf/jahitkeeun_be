<?php

namespace App\Http\Controllers;

use Exception;
use App\User;
use App\Client;

use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    public function register(Request $request) {
        $rules = [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8',

        ];

        $message = [
            'name.required'     => 'Mohon isikan nama anda',
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password anda',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'status'        => '1',
                    'password'      => Hash::make($request->password),
                    // 'created_at'    => date('Y-m-d H:i:s')
                ]);

                Client::create([
                    'user_id'       => $user->id,
                    'status'        => '1',
                    // 'created_at'    => date('Y-m-d H:i:s')

                ]);
                $user->assignRole('client');

            });

            return apiResponse(201, 'success', 'user berhasil mendaftar');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function login(Request $request) {
        $rules = [
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required|min:8',
        ];

        $message = [
            'email.required'    => 'Mohon isikan email anda',
            'email.email'       => 'Mohon isikan email valid',
            'email.exists'      => 'Email belum terdaftar!',
            'password.required' => 'Mohon isikan password anda',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        $data = [
            'email'     => $request->email,
            'password'  => $request->password,
            'status'    => '1'

        ];


        if(!Auth::attempt($data)) {
            return apiResponse(400, 'error', 'Email atau password salah!');
        }


        $token = Auth::user()->createToken('API Token')->accessToken;
        $user = \App\User::find(1);

        if($user->roles = \App\User::find(Auth::user()->id)->getRoleNames()[0] == 'admin') {
                $detail = Auth::user()->admin->photo;
        }
        elseif($user->roles = \App\User::find(Auth::user()->id)->getRoleNames()[0] == 'client'){
                $detail = Auth::user()->client->photo;
        }
        elseif($user->roles = \App\User::find(Auth::user()->id)->getRoleNames()[0] == 'taylor'){
            $detail = Auth::user()->taylor->photo;
            //dd($detail);
        }
        elseif($user->roles = \App\User::find(Auth::user()->id)->getRoleNames()[0] == 'convection'){
            $detail = Auth::user()->convection->photo;
        }




        $image = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-user/'.$detail;







        $token = Auth::user()->createToken('API Token')->accessToken;

        $data   = [
            'token'         => $token,
            'nama'          => Auth::user()->name,
            'email'         => Auth::user()->email,
            'role'          => $user->roles = \App\User::find(Auth::user()->id)->getRoleNames()[0],
            'image'         => $image,
            'client'        => Auth::user()->client,
            'admin'         => Auth::user()->admin,
            'taylor'        => Auth::user()->taylor,
            'convection'    => Auth::user()->convection,

        ];

        return apiResponse(200, 'success', 'berhasil login', $data);
    }

    public function logout() {
        $tokens = Auth::user()->tokens->pluck('id');

        Token::whereIn('id', $tokens)->update([
            'revoked' => true
        ]);

        RefreshToken::whereIn('access_token_id', $tokens)->update([
            'revoked' => true
        ]);

        return apiResponse(200, 'success', 'user berhasil logout');
    }
}
