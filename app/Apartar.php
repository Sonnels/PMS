<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartar extends Model
{
    protected $table = 'apartar';
    protected $primaryKey = 'idApartar';
    public $timestamps = false;
    protected $fillable = [
        'Num_Hab',
        'fecIn',
        'horIn',
        'fecOut',
        'horOut',
        'IdCliente',
        'IdUsuario'
    ];
    protected $guarded = [];
}
