<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    //
    protected $fillable = [
        'id','conta_id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo','categoria_id', 'descricao', 'imagem_doc', 'deleted_at'
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

    public function contas(){
        return $this->belongsTo('App\Conta','conta_id');
    }
}
