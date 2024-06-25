<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HuespedAdicional extends Model
{
    protected $table = 'huesped_adicional';
    protected $primaryKey = 'idHuespedAdicional';
    public $timestamps = false;
    protected $fillable = [
        'IdReserva',
        'IdCliente',
    ];
    protected $guarded = [];
}
