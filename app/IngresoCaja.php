<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoCaja extends Model
{
    protected $table = 'ingreso_caja';
    protected $primaryKey = 'codIngreso';
    public $timestamps = false;
    protected $fillable = [];
    protected $guarded = [];
}
