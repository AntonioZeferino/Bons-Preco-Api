<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parceiroprod;
use Illuminate\Http\Request;

class ParceiroprodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parceiroprod = Parceiroprod::select( 'parceiro_produt.*','parceiros.name as parceiro_name',
        'parceiros.img as parceiro_img','users.name as user_name','users.contacto as user_contacto','users.img as user_img', 'users.status as user_status')
        ->join('produtos', 'produtos.id', '=', 'parceiro_produt.id_produto')
        ->join('parceiros', 'parceiros.id', '=', 'parceiro_produt.id_parceiro')
        ->get();

        return response()->json(
            $parceiroprod
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produto' => 'required',
            'id_parceiro' => 'required',
            'preco' => 'required',
            'data_validad' => 'required',
            'estado_stok' => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Parceiroprod::find($id));
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
        $parceiroprod = Parceiroprod::find($id);
        $parceiroprod->update($request->all());

        return $parceiroprod;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Parceiroprod::destroy($id)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
