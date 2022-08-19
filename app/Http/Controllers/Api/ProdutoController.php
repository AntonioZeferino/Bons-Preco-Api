<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parceiroprod;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{

    public function indexList()
    {
        $produto = Produto::select(
            'produtos.id AS produto_id',
            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',
            'produtos.id AS total'
        )
            ->join('parceiro_produt', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->GroupBy('produtos.id')
            ->OrderBy('produto_id', 'DESC')
            ->get();

        $parceiro_produt = Parceiroprod::all();

        $saida = null;

        foreach ($produto as $key1 => $prod) {
            $valor = null;
            foreach ($parceiro_produt as $key2 => $prodParcei) {
                if ($prod->produto_id == $prodParcei->id_produto) {
                    $valor++;
                }
            }
            $saida[] = [
                'id' => $prod->produto_id,
                'nome' => $prod->produto_nome,
                'img' => $prod->produto_img,
                'total' => $valor,
            ];
        }

        return response()->json(
            $saida
        );
    }

    public function indexListPesquisa(Request $request)
    {
        $produto = Produto::select(
            'produtos.id AS produto_id',
            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',
            'produtos.id AS total'
        )
            ->join('parceiro_produt', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->where('produtos.nome', 'LIKE', '%' . $request['pesquis'] . '%')
            ->GroupBy('produtos.id')
            ->OrderBy('produto_id', 'DESC')
            ->get();

        $parceiro_produt = Parceiroprod::all();

        $saida = null;

        foreach ($produto as $key1 => $prod) {
            $valor = null;
            foreach ($parceiro_produt as $key2 => $prodParcei) {
                if ($prod->produto_id == $prodParcei->id_produto) {
                    $valor++;
                }
            }
            $saida[] = [
                'id' => $prod->produto_id,
                'nome' => $prod->produto_nome,
                'img' => $prod->produto_img,
                'total' => $valor,
            ];
        }

        return response()->json(
            $saida
        );
    }

    public function lojasLigadasProduto()
    {
        $produto = Produto::select(
            'produtos.id AS produto_id',
            'parceiros.id AS parceiro_id',
            'parceiros.nome AS parceiro_nome',
            'parceiro_produt.preco AS preco',
            'parceiro_produt.data_validad AS data_validad',
            'parceiro_produt.estado_stok AS estado_stok',
        )
            ->join('parceiro_produt', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->join('parceiros', 'parceiros.id', '=', 'parceiro_produt.id_parceiro')
            ->get();


        return response()->json(
            $produto
        );
    }

    public function produtoLojas(Request $request)
    {
        $produto = Produto::select(
            'produtos.id AS produto_id',
            'parceiro_produt.id_parceiro AS parceiro_id',
            'parceiro_produt.id AS parceiro_produt_id',
            'parceiros.nome AS parceiro_nome',
            'parceiros.endereco AS parceiro_endereco',
            'parceiro_produt.preco AS preco',
            'parceiro_produt.data_validad AS data_validad',
            'parceiro_produt.estado_stok AS estado_stok'
        )
            ->join('parceiro_produt', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->join('parceiros', 'parceiros.id', '=', 'parceiro_produt.id_parceiro')
            ->where('produtos.id', $request['id'])
            //->GroupBy('produtos.id')
            ->OrderBy('produto_id', 'DESC')
            ->get();

        return response()->json(
            $produto
        );
    }

    public function produtoDaLoja(Request $request)
    {
        $produto = Produto::select(
            'produtos.id AS produto_id',
            'parceiro_produt.id_parceiro AS parceiro_id',
            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',
            'parceiro_produt.preco AS preco',
            'parceiro_produt.data_validad AS data_validad',
            'parceiro_produt.estado_stok AS estado_stok'
        )
            ->join('parceiro_produt', 'parceiro_produt.id_produto', '=', 'produtos.id')
            ->where('parceiro_produt.id_parceiro', $request['id'])
            //->GroupBy('produtos.id')
            ->OrderBy('produto_id', 'DESC')
            ->get();

        return response()->json(
            $produto
        );
    }

    public function produtoSoSistema(Request $request)
    {
        $produto = Produto::select(
            'produtos.id AS produto_id',
            'produtos.nome AS produto_nome',
            'produtos.img AS produto_img',

        )
            ->OrderBy('produto_id', 'ASC')
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
        return response()->json(Produto::find($id));
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
