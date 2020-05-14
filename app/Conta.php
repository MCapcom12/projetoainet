<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    public $timestamps = false;
   
    protected $fillable=['nome','user_id','descricao','saldo_abertura','saldo_atual','data_ultimo_movimento','deleted_at'];

    
    
}
