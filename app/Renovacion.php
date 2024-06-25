<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renovacion extends Model
{
    protected $table = 'renovacion';
    protected $primaryKey = 'idRenovacion';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
