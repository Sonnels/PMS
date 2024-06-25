<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UMedida extends Model
{
    protected $table = 'unidad_medida';
    protected $primaryKey = 'idUnidadMedida';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
