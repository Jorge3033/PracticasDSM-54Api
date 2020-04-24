<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Productos extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'precio',
        'descripcion'

    ];

    public function producto(){
        return $this->hasMany(Productos::class);
    }
}