<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitanteReserva extends Model
{
    //
    protected $table = 'visitantes_reserva';
    protected $primaryKey = 'idVisRes';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
