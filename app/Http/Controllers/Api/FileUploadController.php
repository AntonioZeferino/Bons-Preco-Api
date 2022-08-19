<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userUpload(Request $request)
    {
        $upload = $request->file->store('public/imgParceiro/');
        if ($upload) {

            $user = Parceiro::find($request->id);

            if(Storage::exists('public/imgParceiro/'.$user->img)){
                Storage::delete('public/imgParceiro/'.$user->img);
            }

            $user->img = $request->file->hashName();
            $result =$user->update();

            if ($result) {
               return response()->json([
                   'Img' =>  'Enviado com sucesso! '.$user->img,
                   'User' =>  'Actualizado com sucesso!'
               ]);
            } else {
                return response()->json([
                    'Img' =>  'Enviado com sucesso!',
                    'User' =>  'Not Actualizado com sucesso!'
                ]);
            }
            
        } else {
            return response()->json([
                'Img' =>  'Not Enviado com sucesso!',
                'User' =>  'Not Actualizado com sucesso!'
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
