<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperturaCierre extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'codCaja';
    public $timestamps = false;
    protected $fillable = [
        'horaApertura',
        'fechaApertura',
        'montoApertura',
        'horaCierre',
        'fechaCierre',
        'montoCierre',
        'codUsuario'
    ];
    protected $guarded = [];
}
