<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
  protected $table = 'habitacion';
  protected $primaryKey = 'Num_Hab';
  public $timestamps = false;
  protected $fillable = [
      'Descripcion',
      'Estado',
      'Precio',
      'IdTipoHabitacion',
      'IdNivel'
  ];
  protected $guarded = [

  ];

}
