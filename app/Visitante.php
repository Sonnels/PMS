<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    //
    protected $table = 'visitantes';
    protected $primaryKey = 'idVisitante';
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [

    ];
}
