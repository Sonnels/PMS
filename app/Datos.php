<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datos extends Model
{
    protected $table = 'datos_hotel';
    protected $primaryKey = 'IdHotel';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'logo',
    ];
    protected $guarded = [];
}
