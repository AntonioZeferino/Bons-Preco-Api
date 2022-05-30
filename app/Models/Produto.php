<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = [
        'nome',
        'img',
    ];

    public function reserva()
    {
        return $this->hasOne(Reserva::class);
    }

    public function parceiroprod()
    {
        return $this->hasOne(Parceiroprod::class);
    }
}