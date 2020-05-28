<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'nome', 'tipo'
    ];

    public function movimentos(){
        return $this->hasMany("App\Movimento");
    }
}
