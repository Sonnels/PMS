<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    protected $table = 'detalle_servicio';
    protected $primaryKey = 'idDetalle_servicio';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
