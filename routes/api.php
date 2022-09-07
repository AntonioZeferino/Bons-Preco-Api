<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParceiroController;
use App\Http\Controllers\Api\ParceiroprodController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\ReservaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('api/', function () {
    //dd('welcome');
});

Route::post('me', [AuthController::class, 'me']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->middleware();
Route::post('logout', [AuthController::class, 'logout'])->middleware();

Route::post('produto', [ProdutoController::class, 'index']);
Route::post('produtoList', [ProdutoController::class, 'indexList']);
Route::post('indexListPesquisa', [ProdutoController::class, 'indexListPesquisa']);
Route::post('produtoDaLoja', [ProdutoController::class, 'produtoDaLoja']);
Route::post('produtoLojas', [ProdutoController::class, 'produtoLojas']);
Route::post('lojasLigadasProduto', [ProdutoController::class, 'lojasLigadasProduto']);
Route::post('produtoSoSistema', [ProdutoController::class, 'produtoSoSistema']);
Route::post('produtoSoSistemaID', [ProdutoController::class, 'produtoSoSistemaID']);
Route::post('produtoStore', [ProdutoController::class, 'store'])->middleware();
Route::post('produtoShow', [ProdutoController::class, 'show'])->middleware();
Route::post('produtoUpdate', [ProdutoController::class, 'update'])->middleware();
Route::delete('produto/{id}', [ProdutoController::class, 'destroy'])->middleware();

Route::post('parceiprodut', [ParceiroprodController::class, 'index']);
Route::post('parceiprodutID', [ParceiroprodController::class, 'indexProdutoID']);
Route::post('produtDoParceiro', [ParceiroprodController::class, 'produtDoParceiro']);
Route::post('parceiprodutStore', [ParceiroprodController::class, 'store'])->middleware();
Route::post('parceiprodutShow', [ParceiroprodController::class, 'show'])->middleware();
Route::post('parceiprodutUpdate', [ParceiroprodController::class, 'update'])->middleware();
Route::delete('parceiprodut/{id}', [ParceiroprodController::class, 'destroy'])->middleware();

Route::post('parceiro', [ParceiroController::class, 'index']);
Route::post('userParceiro', [ParceiroController::class, 'userParceiro']);
Route::post('parceiroStore', [ParceiroController::class, 'store'])->middleware();
Route::post('parceiroShow', [ParceiroController::class, 'show'])->middleware();
Route::post('parceiroUpdate', [ParceiroController::class, 'update'])->middleware();
Route::delete('parceiro/{id}', [ParceiroController::class, 'destroy'])->middleware();

Route::post('reserva', [ReservaController::class, 'index']);
Route::post('userReserva', [ReservaController::class, 'userReserva']);
Route::post('lojaReserva', [ReservaController::class, 'lojaReserva']);
Route::post('reservaStore', [ReservaController::class, 'store'])->middleware();
Route::post('reservaShow', [ReservaController::class, 'show'])->middleware();
Route::post('reservaUpdate', [ReservaController::class, 'update'])->middleware();
Route::delete('reserva/{id}', [ReservaController::class, 'destroy'])->middleware();

Route::post('userUpdate', [AuthController::class, 'update'])->middleware();
Route::post('userUpload', [FileUploadController::class, 'userUpload'])->middleware();
