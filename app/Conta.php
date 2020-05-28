<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Conta extends Model
{
    use SoftDeletes;

    public $timestamps = false;
   
    protected $fillable=['user_id','nome','descricao','saldo_atual','saldo_abertura','data_ultimo_movimento'];


    
   

    

   
    
    public function movimentos(){
        return $this->hasMany('App\Movimento');
    }

    public function utilizadores_autorizados(){
        return $this->belongsToMany('App\User','autorizacoes_contas');
    }
}
