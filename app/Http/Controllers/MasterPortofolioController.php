<?php

namespace App\Http\Controllers;

use Exception;
use App\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MasterPortofolioController extends Controller
{
    public function index()
    {

        $portofolios = DB::table('portofolios')
                        ->join('taylors', 'portofolios.taylor_id', '=', 'taylors.id')
                        ->join('users', 'taylors.user_id', '=', 'users.id')
                        ->select(['portofolios.id as id', 'taylors.id as taylor_id', 'users.name as taylor_name', 'portofolios.desc as portofolio_description', 'portofolios.photo1 as portofolio_photo1', 'portofolios.photo2 as portofolio_photo2', 'portofolios.photo3 as portofolio_photo3', 'portofolios.photo4 as portofolio_photo4', 'portofolios.photo5 as portofolio_photo5', ])
                        ->paginate();


                        if($portofolios->total() > 0) {
                            return apiResponse(200, 'success', 'List portofolio', $portofolios);
                        } else {
                            return Response::json(apiResponse(404, 'not found', 'Data portofolio tidak ditemukan'), 404);
                        }
    }

    public function showPortoByPorto($id) {

        $portofolios = DB::table('portofolios')
                        ->join('taylors', 'portofolios.taylor_id', '=', 'taylors.id')
                        ->join('users', 'taylors.user_id', '=', 'users.id')
                        ->select(['portofolios.id as portofolio_id', 'taylors.id as taylor_id', 'users.name as taylor_name', 'portofolios.desc as portofolio_description', 'portofolios.photo1 as portofolio_photo1', 'portofolios.photo2 as portofolio_photo2', 'portofolios.photo3 as portofolio_photo3', 'portofolios.photo4 as portofolio_photo4', 'portofolios.photo5 as portofolio_photo5', ])
                        ->where('portofolios.id', $id)
                        ->paginate();

        if($portofolios->total() > 0) {
            return apiResponse(200, 'success', $portofolios);
        } else {

            return Response::json(apiResponse(404, 'not found', 'Portofolio tidak ditemukan'), 404);
        }

    }

    public function showPortoByTaylor($id) {

        $portofolios = DB::table('portofolios')
                        ->join('taylors', 'portofolios.taylor_id', '=', 'taylors.id')
                        ->join('users', 'taylors.user_id', '=', 'users.id')
                        ->select(['portofolios.id as portofolio_id', 'taylors.id as taylor_id', 'users.name as taylor_name', 'portofolios.desc as portofolio_description', 'portofolios.photo1 as portofolio_photo1', 'portofolios.photo2 as portofolio_photo2', 'portofolios.photo3 as portofolio_photo3', 'portofolios.photo4 as portofolio_photo4', 'portofolios.photo5 as portofolio_photo5', ])
                        ->where('taylors.id', $id)
                        ->paginate();

        if($portofolios->total() > 0) {
            return apiResponse(200, 'success', $portofolios);
        } else {

            return Response::json(apiResponse(404, 'not found', 'Portofolio tidak ditemukan'), 404);
        }

    }


    public function create(Request $request) {



        $rules = [
            'desc'        => 'required',
            'photo1'      => 'required',

            'taylor_id'   => 'required',

        ];

        $message = [
            'desc.required'         => 'Mohon isikan deskripsi portofolio',
            'photo1.required'       => 'Mohon isikan photo 1',

            'taylor_id.required'    => 'Mohon isikan data penjahit',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {

            if($request->hasFile('photo1')){


                $extension = $request->file('photo1')->getClientOriginalExtension();

                $portoPhoto1 = '1'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo1')->move($path, $portoPhoto1);

            }


            if(!$request->hasFile('photo2') == NULL){

                $extension = $request->file('photo2')->getClientOriginalExtension();

                $portoPhoto2 = '2'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo2')->move($path, $portoPhoto2);

            } else {
                $portoPhoto2 = NULL;
            }


            if(!$request->hasFile('photo3') == NULL){

                $extension = $request->file('photo3')->getClientOriginalExtension();

                $portoPhoto3 = '3'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo3')->move($path, $portoPhoto3);

            } else {
                $portoPhoto3 = NULL;
            }


            if(!$request->hasFile('photo4') == NULL){


                $extension = $request->file('photo4')->getClientOriginalExtension();

                $portoPhoto4 = '4'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo4')->move($path, $portoPhoto4);

            } else {
                $portoPhoto4 = NULL;
            }


            if(!$request->hasFile('photo5') == NULL){


                $extension = $request->file('photo5')->getClientOriginalExtension();

                $portoPhoto5 = '5'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo5')->move($path, $portoPhoto5);

            } else {
                $portoPhoto5 = NULL;
            }




            DB::transaction(function () use ($request, $portoPhoto1, $portoPhoto2, $portoPhoto3, $portoPhoto4, $portoPhoto5) {
                $portofolio = Portofolio::create([
                    'desc'           => $request->desc,
                    'photo1'         => $portoPhoto1,
                    'photo2'         => $portoPhoto2,
                    'photo3'         => $portoPhoto3,
                    'photo4'         => $portoPhoto4,
                    'photo5'         => $portoPhoto5,
                    'taylor_id'      => $request->taylor_id,
                ]);

            });


            return apiResponse(201, 'success', 'portofolio berhasil ditambahkan');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function update(Request $request, $id) {




        $rules = [
            'desc'        => 'required',
            'photo1'      => 'required',

            'taylor_id'   => 'required',

        ];

        $message = [
            'desc.required'         => 'Mohon isikan deskripsi portofolio',
            'photo1.required'       => 'Mohon isikan photo 1',

            'taylor_id.required'    => 'Mohon isikan datapenjahit',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }



        try {

            if($request->has('photo1')){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo1;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo1')->getClientOriginalExtension();

                $portoPhoto1 = '1'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo1')->move($path, $portoPhoto1);

            }

            if(!$request->hasFile('photo2') == NULL){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo2;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo2')->getClientOriginalExtension();

                $portoPhoto2 = '2'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo2')->move($path, $portoPhoto2);

            } else {
                $portoPhoto2 = NULL;
            }


            if(!$request->hasFile('photo3') == NULL){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo3;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }



                $extension = $request->file('photo3')->getClientOriginalExtension();

                $portoPhoto3 = '3'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo3')->move($path, $portoPhoto3);

            } else {
                $portoPhoto3 = NULL;
            }



            if(!$request->hasFile('photo4') == NULL){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo4;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo4')->getClientOriginalExtension();

                $portoPhoto4 = '4'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo4')->move($path, $portoPhoto4);

            } else {
                $portoPhoto4 = NULL;
            }

            if(!$request->hasFile('photo5') == NULL){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo5;

                if($oldImage){
                    $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo5')->getClientOriginalExtension();

                $portoPhoto5 = '5'.date('YmdHis').'.'.$extension;

                $path = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/';

                $request->file('photo5')->move($path, $portoPhoto5);

            } else {
                $portoPhoto5 = NULL;
            }


            DB::transaction(function () use ($request, $id, $portoPhoto1, $portoPhoto2, $portoPhoto3, $portoPhoto4, $portoPhoto5) {

                Portofolio::where('id', $id)->update([
                    'desc'          => $request->desc,
                    'photo1'        => $portoPhoto1,
                    'photo2'        => $portoPhoto2,
                    'photo3'        => $portoPhoto3,
                    'photo4'        => $portoPhoto4,
                    'photo5'        => $portoPhoto5,
                    'taylor_id'     => $request->taylor_id,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            });

            return apiResponse(202, 'success', 'data portofolio berhasil diperbaharui');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }

    public function deleteByPortoId($id) {
        $portofolio = Portofolio::where('id','=',$id)->first();
        $oldImage1 = $portofolio->photo1;
        $oldImage2 = $portofolio->photo2;
        $oldImage3 = $portofolio->photo3;
        $oldImage4 = $portofolio->photo4;
        $oldImage5 = $portofolio->photo5;

        if($oldImage1){
            $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage1;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if(!$oldImage2 == NULL){
            $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage2;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if(!$oldImage3 == NULL){
            $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage3;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if(!$oldImage4 == NULL){
            $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage4;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if(!$oldImage5 == NULL){
            $pleaseRemove = '/home/jahitkee/public_html/api.jahitkeeun.my.id/photo-portofolio/'.$oldImage5;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        try {
            DB::transaction(function () use ($id) {
                Portofolio::where('id', $id)->delete();
            });

            return apiResponse(202, 'success', 'porto berhasil dihapus');
        } catch(Exception $e) {
            return apiResponse(400, 'error', 'error', $e);
        }
    }
}
