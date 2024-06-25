<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
  protected $table = 'cliente';
  protected $primaryKey = 'IdCliente';
  public $timestamps = false;
  protected $fillable = [
    'Nombre' ,
    'Apellido' ,
    'Celular',
    'Correo' ,
    'TipDocumento',
    'NumDocumento',
    'Direccion' ,
    'nroMatricula',
  ];

  protected $guarded = [

  ];

}
