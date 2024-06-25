<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    //
    protected $table = 'egreso_caja';
    protected $primaryKey = 'codEgreso';
    public $timestamps = false;
    protected $fillable = [
        'horaEgreso',
        'fechaEgreso',
        'tipo',
        'entregadoA',
        'motivo',
        'importe',
        'estado',
        'codCaja'
    ];
    protected $guarded = [];
}
