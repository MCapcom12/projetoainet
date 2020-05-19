<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Movimento;
use App\Conta;


use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index(Request $request)
    {
        $user= $request->user();

        if(request()->has('conta') && request('conta') != ""){
            $movs = $user->movimentos()->where('conta_id', request('conta'))->paginate(10); 
        }else{
            $movs = $user->movimentos()->paginate(10);
        }

         $contas=$user->contas;

         //$movs=$user->movimentos()->paginate(10);
         //$movs = Movimento::paginate(15);
        // $contas_id = collect();
         
        
        // //dd(Movimento::where('conta_id',4427)->get());
        //  foreach ($contas as $conta){
            
        //         $contas_id->push($conta->id);

        //  }
         
        //  $movs=Movimento::whereIn('conta_id',$contas_id)->paginate(10);
         //$movs->paginate(10);
        $selectedConta= Conta::groupBy('nome')->pluck('nome')->toArray(); 
        //dd($selectedConta);

         return view('Movimentos.index')->withMovimentos($movs)
                                        ->withContas($contas)
                                        ->withSelectedConta($selectedConta);
                                 
    }
    
}
