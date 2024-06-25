<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetLimpieza extends Model
{
    protected $table = 'det_limpieza';
    protected $primaryKey = 'idDetLim';
    public $timestamps = false;
    protected $fillable = [];
    protected $guarded = [];
}
