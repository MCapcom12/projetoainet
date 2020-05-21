<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Movimento;
use App\Conta;
use App\Http\Requests\MovimentoPost;


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

         return view('movimentos.index')->withMovimentos($movs)
                                        ->withContas($contas)
                                        ->withSelectedConta($selectedConta);                        
    }


    public function create(Conta $conta){

        
        $newMovimento= new Movimento;
        
        return view('movimentos.create')->withConta($conta)
                                        ->withMovimento($newMovimento);
    }



    public function store(MovimentoPost $request, Conta $conta){

        
        $validated_data = $request->validated();
        $validated_data["conta_id"]=$conta->id;
        $validated_data['saldo_inicial']=$conta->saldo_atual;
        //dd($validated_data['saldo_inicial']);
        if($validated_data["tipo"]=='D'){
            $validated_data["saldo_final"]= $validated_data["saldo_inicial"]-$validated_data['valor'];
        
        }else{
            $validated_data["saldo_final"]= $validated_data["saldo_inicial"]+$validated_data['valor'];      
            //dd($validated_data["saldo_final"]);
        }

        $conta->saldo_atual=$validated_data["saldo_final"];
        //dd($conta->saldo_atual);
         
        Movimento::create($validated_data);
        $conta->save();
        

        return redirect()->route('contas.detalhe' ,['conta'=>$conta])
            ->with('alert-msg','Movimento criada com sucesso')
           ->with('alert-type','success');
    }

    
}
