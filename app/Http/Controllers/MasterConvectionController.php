<?php

namespace App\Http\Controllers;

use Exception;
use App\User;
use App\Convection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterConvectionController extends Controller
{
    public function index()
    {

        $convections = DB::table('users')
                ->join('convections', 'users.id', '=', 'convections.user_id')
                ->select(['users.id as user_id', 'convections.id as convection_id', 'users.name as convection_name', 'convections.photo as convection_photo', 'convections.phone as convection_phone', 'convections.dateBirth as date_birth', 'convections.placeBirth as place_birth',])
                ->paginate();


                if($convections->total() > 0) {
                    return apiResponse(200, 'success', 'List konveksi', $convections);
                } else {
                    return Response::json(apiResponse(404, 'not found', 'Data konveksi tidak ditemukan'), 404);
                }

    }

    public function showByUserId($id) {
        $convection = DB::table('users')
                ->join('convections', 'users.id', '=', 'convections.user_id')
                ->where('users.id', $id)
                ->select(['users.id as user_id', 'convections.id as convection_id', 'users.name as convection_name', 'convections.photo as convection_photo', 'convections.phone as convection_phone', 'convections.dateBirth as date_birth', 'convections.placeBirth as place_birth',])
                ->paginate();

        if($convection->total() > 0) {
            return apiResponse(200, 'success', $convection);
        }

        return Response::json(apiResponse(404, 'not found', 'Data konveksi tidak dapat ditemukan'), 404);
    }


    public function showByConvectionId($id) {
        $convection = DB::table('users')
                ->join('convections', 'users.id', '=', 'convections.user_id')
                ->where('convections.id', $id)
                ->select(['users.id as user_id', 'convections.id as convection_id', 'users.name as convection_name', 'convections.photo as convection_photo', 'convections.phone as convection_phone', 'convections.dateBirth as date_birth', 'convections.placeBirth as place_birth',])
                ->paginate();

        if($convection->total() > 0) {
            return apiResponse(200, 'success', $convection);
        }

        return Response::json(apiResponse(404, 'not found', 'Data konveksi tidak dapat ditemukan'), 404);
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
            'name.required'     => 'Mohon isikan nama konveksi',
            'email.required'    => 'Mohon isikan email konveksi',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password konveksi',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'     => 'Mohon isikan nomor handphone konveksi',
            'dateBirth.required' => 'Mohon isikan tanggal lahir konveksi',
            'placeBirth.required' => 'Mohon isikan tempat lahir konveksi',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {


            if($request->has('photo')){


                $extension = $request->file('photo')->getclientOriginalExtension();

                $convectionPhoto = date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/convection/');

                $request->file('photo')->move($path, $convectionPhoto);

            }

            DB::transaction(function () use ($request, $convectionPhoto ) {
                $user = User::create([
                    'name'          => $request->name,
                    'email'         => $request->email,
                    'password'      => Hash::make($request->password),
                    'status'        => '1'
                ]);

                Convection::create([
                    'user_id'       => $user->id,
                    'photo'         => $convectionPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'status'        => '1',
                ]);
                $user->assignRole('convection');

            });

            return apiResponse(201, 'success', 'konveksi berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function updateByUserId(Request $request, $id) {



        $rules = [
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$id,
            'password'   => 'required|min:8',
            'phone'      => 'required',
            'dateBirth'  => 'required',
            'placeBirth' => 'required',
        ];

        $message = [
            'name.required'     => 'Mohon isikan nama konveksi',
            'email.required'    => 'Mohon isikan email konveksi',
            'email.email'       => 'Mohon isikan email valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Mohon isikan password konveksi',
            'password.min'      => 'Password wajib mengandung minimal 8 karakter',
            'phone.required'     => 'Mohon isikan nomor handphone konveksi',
            'dateBirth.required' => 'Mohon isikan tanggal lahir konveksi',
            'placeBirth.required' => 'Mohon isikan tempat lahir konveksi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {

            if($request->has('photo')){
                $userDetail = Convection::where('user_id', '=', $id)->first();
                $oldImage = $userDetail->photo;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/convection/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


            $extension = $request->file('photo')->getclientOriginalExtension();

            $convectionPhoto = date('YmdHis').'.'.$extension;

            $path = base_path('public/photos/convection/');

            $request->file('photo')->move($path, $convectionPhoto);

            }


            DB::transaction(function () use ($request, $id, $convectionPhoto) {
                User::where('id', $id)->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                Convection::where('user_id', $id)->update([
                    'photo'         => $convectionPhoto,
                    'phone'         => $request->phone,
                    'dateBirth'     => $request->dateBirth,
                    'placeBirth'    => $request->placeBirth,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data konveksi berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function deleteByUserId($id) {
        $userDetail = Convection::where('user_id','=',$id)->first();
        $oldImage = $userDetail->photo;

        if($oldImage){
            $pleaseRemove = base_path('public/photos/convection/').$oldImage;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        try {
            DB::transaction(function () use ($id) {
                Convection::where('user_id', $id)->delete();
                User::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'user berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
