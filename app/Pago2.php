<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago2 extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'idPagos';
    public $timestamps = false;
    protected $fillable = [
        'fecPag',
        'motPag',
        'metPag',
        'desPag',
        'monPag',
        'IdReserva',
        'codCaja'
    ];
    protected $guarded = [

    ];
}

