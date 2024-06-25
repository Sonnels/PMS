<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoLimpieza extends Model
{
    protected $table = 'tipo_limpieza';
    protected $primaryKey = 'idLim';
    public $timestamps = false;
    protected $fillable = [];
    protected $guarded = [];
}
