<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documento';
    protected $primaryKey = 'idTipDoc';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
