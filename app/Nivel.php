<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
  protected $table = 'nivel';
  protected $primaryKey = 'IdNivel';
  public $timestamps = false;
  protected $fillable = [
      'Denominacion',
  ];
  protected $guarded = [

  ];

}
