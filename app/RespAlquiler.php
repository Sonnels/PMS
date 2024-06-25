<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespAlquiler extends Model
{
    protected $table = 'resp_alquiler';
    protected $primaryKey = 'idResAlq';
    public $timestamps = false;
    protected $fillable = [
    ];

    protected $guarded = [

    ];
}
