<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'idpro';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
