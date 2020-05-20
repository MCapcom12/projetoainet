<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Conta extends Model
{
    

    public $timestamps = false;
   
    protected $fillable=['id','user_id','nome','descricao','saldo_atual','saldo_abertura','data_ultimo_movimento','deleted_at'];

    public function __construct(array $attributes = [])
    {
        
        $this->user_id = Auth::id();
        //$this->saldo_atual = $this->saldo_abertura;
        
     
        parent::__construct($attributes);
    }
    
}
