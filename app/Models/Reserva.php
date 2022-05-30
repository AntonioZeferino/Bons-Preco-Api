<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = [
        'id_produto',
        'id_parceiro',
        'id_user',
        'estado',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function parceiro()
    {
        return $this->belongsTo(Parceiro::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

}