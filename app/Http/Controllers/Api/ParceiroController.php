<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parceiro;
use Illuminate\Http\Request;

class ParceiroController extends Controller
{

    public function userParceiro(Request $request)
    {
        $parceiro = Parceiro::select(
            'parceiros.id AS id',
            'parceiros.dono_id_user AS dono_id_user',
            'parceiros.nome AS nome',
            'parceiros.img AS img',
            'parceiros.horario AS horario',
            'parceiros.entregas AS entregas',
            'parceiros.endereco AS endereco',
            'parceiros.contacto AS contacto',
            'parceiros.email AS email',
        )
            ->where('parceiros.dono_id_user', $request['id'])
            ->get();

        return response()->json(
            $parceiro
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Parceiro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file2 != null) {
            $upload = $request->file2->store('public/imgParceiro/');
            if ($upload) {
                $request['img'] = $request->file2->hashName();
            }
        }

        $request->validate([
            'nome' => 'required',
            'dono_id_user' => 'required',
            'endereco' => 'required',
            'contacto' => 'required',
            'email' => 'required',

        ]);

        if (Parceiro::create($request->all())) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Parceiro::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $parceiro = Parceiro::find($request['id']);
        $parceiro->update($request->all());

        return $parceiro;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Parceiro::destroy($id)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
