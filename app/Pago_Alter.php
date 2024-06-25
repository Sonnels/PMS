<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago_Alter extends Model
{
    protected $table = 'pago';
    protected $primaryKey = 'IdReserva';
    public $timestamps = false;
    protected $fillable = [


    ];
    protected $guarded = [

    ];
}
