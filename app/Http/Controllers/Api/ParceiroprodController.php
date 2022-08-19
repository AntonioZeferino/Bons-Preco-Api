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
        $parceiroprod = Parceiroprod::select(
            'parceiro_produt.*',
            'parceiros.nome as parceiro_nome',
            'parceiros.img as parceiro_img',
            'parceiros.horario as parceiro_horario',
            'parceiros.entregas as parceiro_entregas',
            'parceiros.endereco as parceiro_endereco',
            'parceiros.contacto as parceiro_contacto',
            'parceiros.email as parceiro_email'
        )
            ->join('parceiros', 'parceiros.id', '=', 'parceiro_produt.id_parceiro')
            ->get();

        return response()->json(
            $parceiroprod
        );
    }

    public function indexProdutoID(Request $request)
    {
        $parceiroprod = Parceiroprod::select(
            'parceiro_produt.*',
            'parceiros.nome as parceiro_nome',
            'parceiros.img as parceiro_img',
            'parceiros.horario as parceiro_horario',
            'parceiros.entregas as parceiro_entregas',
            'parceiros.endereco as parceiro_endereco',
            'parceiros.contacto as parceiro_contacto',
            'parceiros.email as parceiro_email'
        )
            ->join('parceiros', 'parceiros.id', '=', 'parceiro_produt.id_parceiro')
            ->where('parceiro_produt.id_produto', $request['id'])
            ->get();

        return response()->json(
            $parceiroprod
        );
    }

    public function lojaReserva(Request $request)
    {
        $parceiroprod = Parceiroprod::select(
            'produtos.id AS id_produto',
            'parceiros.id AS id_parceiro',

            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',
            'parceiro_produt.preco AS preco',
            'parceiro_produt.data_validad AS data_validad',
            'parceiro_produt.estado_stok AS estado_stok'
        )
            ->join('produtos', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->join('parceiros', 'parceiro_produt.id_parceiro', '=', 'parceiros.id')
            ->where('parceiro_produt.id_parceiro', $request['idpar'])
            //->where('parceiro_produt.id_produto', $request['idpro'])
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

        if (Parceiroprod::create($request->all())) {
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
