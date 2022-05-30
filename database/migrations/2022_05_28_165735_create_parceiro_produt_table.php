<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParceiroProdutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parceiro_produt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produto')->unsigned()->references('id')->on('produtos');
            $table->foreignId('id_parceiro')->unsigned()->references('id')->on('parceiros');
            $table->double('preco');
            $table->date('data_validad');
            $table->tinyInteger('estado_stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parceiro_produt');
    }
}
