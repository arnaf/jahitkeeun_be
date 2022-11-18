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


        return apiResponse(200, 'success', 'List portofolio', $portofolios);

    }

    public function show($id) {

        $portofolios = DB::table('portofolios')
                        ->join('taylors', 'portofolios.taylor_id', '=', 'taylors.id')
                        ->join('users', 'taylors.user_id', '=', 'users.id')
                        ->select(['portofolios.id as id', 'taylors.id as taylor_id', 'users.name as taylor_name', 'portofolios.desc as portofolio_description', 'portofolios.photo1 as portofolio_photo1', 'portofolios.photo2 as portofolio_photo2', 'portofolios.photo3 as portofolio_photo3', 'portofolios.photo4 as portofolio_photo4', 'portofolios.photo5 as portofolio_photo5', ])
                        ->where('portofolios.id', $id)
                        ->paginate();

        if($portofolios) {
            return apiResponse(200, 'success', $portofolios);
        }

        return Response::json(apiResponse(404, 'not found', 'Portofolio tidak ditemukan'), 404);
    }


    public function create(Request $request) {



        $rules = [
            'desc'        => 'required',
            'photo1'      => 'required',
            'photo2'      => 'required',
            'photo3'      => 'required',
            'photo4'      => 'required',
            'photo5'      => 'required',
            'taylor_id'   => 'required',

        ];

        $message = [
            'desc.required'         => 'Mohon isikan deskripsi portofolio',
            'photo1.required'       => 'Mohon isikan photo 1',
            'photo2.required'       => 'Mohon isikan photo 2',
            'photo3.required'       => 'Mohon isikan photo 3',
            'photo4.required'       => 'Mohon isikan photo 4',
            'photo5.required'       => 'Mohon isikan photo 5',
            'taylor_id.required'    => 'Mohon isikan data penjahit',

        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) {
            return apiResponse(400, 'error', 'Data tidak lengkap ', $validator->errors());
        }

        try {

            if($request->has('photo1')){


                $extension = $request->file('photo1')->getClientOriginalExtension();

                $portoPhoto1 = '1'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo1')->move($path, $portoPhoto1);

            }


            if($request->has('photo2')){

                $extension = $request->file('photo2')->getClientOriginalExtension();

                $portoPhoto2 = '2'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo2')->move($path, $portoPhoto2);

            }


            if($request->has('photo3')){


                $extension = $request->file('photo3')->getClientOriginalExtension();

                $portoPhoto3 = '3'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo3')->move($path, $portoPhoto3);

            }


            if($request->has('photo4')){


                $extension = $request->file('photo4')->getClientOriginalExtension();

                $portoPhoto4 = '4'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo4')->move($path, $portoPhoto4);

            }


            if($request->has('photo5')){


                $extension = $request->file('photo5')->getClientOriginalExtension();

                $portoPhoto5 = '5'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo5')->move($path, $portoPhoto5);

            }




            // if($request->has('photo'.$i)){
            //     $extension = $request->file('photo'.$i)->getClientOriginalExtension();
            //     $portofolioPhoto[] = date('YmdHis').'.'.$extension;
            //     $path = base_path('public/photos/portofolio/');
            //     $request->file('photo'.$i)->move($path, $portofolioPhoto[]);
            //     }



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
            'photo2'      => 'required',
            'photo3'      => 'required',
            'photo4'      => 'required',
            'photo5'      => 'required',
            'taylor_id'   => 'required',

        ];

        $message = [
            'desc.required'         => 'Mohon isikan deskripsi portofolio',
            'photo1.required'       => 'Mohon isikan photo 1',
            'photo2.required'       => 'Mohon isikan photo 2',
            'photo3.required'       => 'Mohon isikan photo 3',
            'photo4.required'       => 'Mohon isikan photo 4',
            'photo5.required'       => 'Mohon isikan photo 5',
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
                    $pleaseRemove = base_path('public/photos/portofolio/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo1')->getClientOriginalExtension();

                $portoPhoto1 = '1'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo1')->move($path, $portoPhoto1);

            }

            if($request->has('photo2')){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo2;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/portofolio/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo2')->getClientOriginalExtension();

                $portoPhoto2 = '2'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo2')->move($path, $portoPhoto2);

            }

            if($request->has('photo3')){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo3;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/portofolio/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo3')->getClientOriginalExtension();

                $portoPhoto3 = '3'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo3')->move($path, $portoPhoto3);

            }

            if($request->has('photo4')){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo4;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/portofolio/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo4')->getClientOriginalExtension();

                $portoPhoto4 = '4'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo4')->move($path, $portoPhoto4);

            }

            if($request->has('photo5')){
                $portofolio = Portofolio::where('id','=',$id)->first();
                $oldImage = $portofolio->photo5;

                if($oldImage){
                    $pleaseRemove = base_path('public/photos/portofolio/').$oldImage;

                    if(file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }
                }


                $extension = $request->file('photo5')->getClientOriginalExtension();

                $portoPhoto5 = '5'.date('YmdHis').'.'.$extension;

                $path = base_path('public/photos/portofolio/');

                $request->file('photo5')->move($path, $portoPhoto5);

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

    public function delete($id) {
        $portofolio = Portofolio::where('id','=',$id)->first();
        $oldImage1 = $portofolio->photo1;
        $oldImage2 = $portofolio->photo2;
        $oldImage3 = $portofolio->photo3;
        $oldImage4 = $portofolio->photo4;
        $oldImage5 = $portofolio->photo5;

        if($oldImage1){
            $pleaseRemove = base_path('public/photos/portofolio/').$oldImage1;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if($oldImage2){
            $pleaseRemove = base_path('public/photos/portofolio/').$oldImage2;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if($oldImage3){
            $pleaseRemove = base_path('public/photos/portofolio/').$oldImage3;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if($oldImage4){
            $pleaseRemove = base_path('public/photos/portofolio/').$oldImage4;

            if(file_exists($pleaseRemove)) {
                unlink($pleaseRemove);
            }
        }
        if($oldImage5){
            $pleaseRemove = base_path('public/photos/portofolio/').$oldImage5;

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
