<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parceiroprod extends Model
{
    protected $table = 'parceir_produt';
    protected $fillable = [
        'id_produto',
        'id_parceiro',
        'preco',
        'data_validad',
        'estado_stok',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function parceiro()
    {
        return $this->belongsTo(parceiro::class);
    }
}