<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalleventa extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'codDetalle_venta';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
