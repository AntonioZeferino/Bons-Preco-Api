<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parceiro extends Model
{
    protected $table = 'parceiros';
    protected $fillable = [
        'dono_id_user',
        'nome',
        'img',
        'horario',
        'entregas',
        'endereco',
        'contacto',
        'email',
        'password',
    ];

    public function parceiroprod()
    {
        return $this->hasOne(Parceiroprod::class);
    }

    public function reserva()
    {
        return $this->hasOne(Reserva::class);
    }
}
