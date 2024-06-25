<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'IdReserva';
    public $timestamps = false;
    protected $fillable = [
        'FechReserva',
        'FechEntrada',
        'FechSalida',
        'HoraEntrada',
        'horaSalida',
        'CostoAlojamiento',
        'descuento',
        'Observacion',
        'Estado',
        'IdCliente',
        'Num_Hab',
        'IdUsuario',
        'codCaja',
    ];
    protected $guarded = [

    ];
}
