<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{

    public function userReserva(Request $request)
    {
        $reserva = Reserva::select(
            'reservas.id AS id_reservas',
            'reservas.id_produto AS id_produto',
            'reservas.id_parceiro AS id_parceiro',
            'reservas.id_user AS id_user',
            'reservas.estado AS estado',

            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',
            'parceiros.nome AS parceiro_nome',
            //'parceiro_produt.preco AS preco',
        )
            ->join('produtos', 'produtos.id', '=', 'reservas.id_produto')
            ->join('parceiros', 'parceiros.id', '=', 'reservas.id_parceiro')
            //->join('parceiro_produt', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->where('reservas.id_user', $request['idUser'])
            ->get();

        return response()->json(
            $reserva
        );
    }

    public function lojaReserva(Request $request)
    {
        $parceiroprod = Reserva::select(
            'reservas.id AS id_reservas',
            'reservas.id_user AS id_user',
            'reservas.estado AS estado',
            'users.nome AS user_nome',
            'produtos.id AS id_produto',
            'parceiros.id AS id_parceiro',

            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',
            'parceiro_produt.preco AS preco',
            'parceiro_produt.data_validad AS data_validad',
            'parceiro_produt.estado_stok AS estado_stok'
        )
            ->join('produtos', 'reservas.id_produto', '=', 'produtos.id')
            ->join('parceiros', 'reservas.id_parceiro', '=', 'parceiros.id')
            ->join('users', 'reservas.id_user', '=', 'users.id')
            ->join('parceiro_produt', 'produtos.id', '=', 'parceiro_produt.id_produto')
            ->where('reservas.id_parceiro', $request['idpar'])
            ->where('parceiro_produt.id_parceiro', $request['idpar'])
            ->get();

        return response()->json(
            $parceiroprod

        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Reserva::all());
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
            'id_produto',
            'id_parceiro',
            'id_user',
        ]);

        if (Reserva::create($request->all())) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
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
        return response()->json(Reserva::find($id));
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
        $reserva = Reserva::find($request->id);

        if ($reserva->update($request->all())) {
            return response()->json([
                'status' => true,
            ]);
        } else {

            return response()->json([
                'status' => false,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Reserva::destroy($id)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
