<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    //
    protected $fillable = [
        'id','user_id', 'nome', 'descricao', 'saldo_abertura', 'saldo_atual', 'saldo_ultimo_movimento', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    
}
