<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
  protected $table = 'consumo';
  protected $primaryKey = 'IdConsumo';
  public $timestamps = false;
  protected $fillable = [
      'Cantidad',
      'Total',
      'Estado',
      'FechConsumo',
      'IdProducto',
      'IdReserva',
  ];
  protected $guarded = [

  ];

}
