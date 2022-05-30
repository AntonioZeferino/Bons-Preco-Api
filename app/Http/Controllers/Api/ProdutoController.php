<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{

    public function indexList()
    {
        $produto = Produto::select( 'produto.*','parceiros.name as cidade',
        'cidades.id as cidade_id','users.name as user_name','users.contacto as user_contacto','users.img as user_img', 'users.status as user_status')
        ->join('produtos', 'produtos.id', '=', 'parceiro_produt.id_produto')
        ->join('parceiros', 'parceiros.id', '=', 'parceiro_produt.id_parceiro')
        ->get();

        return response()->json(
            $produto
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Produto::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file != null) {
            $upload = $request->file->store('public/imgProduto/');
            if ($upload) {
                $request['img'] = $request->file->hashName();
            }
        }

        $request->validate([
            'nome' => 'required',
            'img' => 'required',
        ]);

        if (Produto::create($request->all())) {
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
        return response()->json(Produto::find());
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
        $produto = Produto::find();

        if ($request->file != null) {
            $upload = $request->file->store('public/imgProduto/');
            if ($upload) {
                $request['img'] = $request->file->hashName();
                if (Storage::exists('public/imgProduto/' . $produto->img)) {
                    Storage::delete('public/imgProduto/' . $produto->img);
                }
            }
        }

        $produto->update($request->all());

        return $produto;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Produto::destroy($id)) {

            $produto = Produto::find($id);
            if ($produto->img != 'null') {
                if (Storage::exists('public/imgProduto/' . $produto->img)) {
                    Storage::delete('public/imgProduto/' . $produto->img);
                }
            }

            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
