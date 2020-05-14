<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $fillable=['nome','descricao','saldo_abertura','saldo_atual','data_ultimo_movimento','deleted_at'];

    
}
