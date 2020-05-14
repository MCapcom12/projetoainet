<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimento;
use App\Conta;

use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index(Request $request)
    {
        $conta= $request->conta ?? '';
        
         $qry= Movimento::query();
  
         if($conta){
            
             $qry->where('conta_id',$conta->id);
         }
         $movs=$qry->paginate(10);

         return view('Movimentos.index')->withMovimentos($movs);                                  
    }
    
}
