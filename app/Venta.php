<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'codVenta';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
