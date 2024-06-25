<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $table = 'producto';
  protected $primaryKey = 'IdProducto';
  public $timestamps = false;
  protected $fillable = [
      'NombProducto',
      'Imagen',
      'Precio',
      'Descripcion',
      'IdCategoria'
  ];
  protected $guarded = [

  ];

}
