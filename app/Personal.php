<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'idPer';
    public $timestamps = false;
    protected $fillable = [];
    protected $guarded = [];
}
