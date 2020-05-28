<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Movimento;
use App\Conta;
use App\Categoria;
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

        $categorias=Categoria::all();
        $newMovimento= new Movimento;
        return view('movimentos.create')->withConta($conta)
                                        ->withCategorias($categorias)
                                        ->withMovimento($newMovimento);
    }



    public function store(MovimentoPost $request, Conta $conta){

        
        $validated_data = $request->validated();
        if($validated_data["categoria_id"]<=12 && $validated_data["tipo"] == 'D'){
            return redirect()->back()->with('alert-msg','Movimento não criado. Tipo e Categoria do Movimento não coincidem!')
                                     ->with('alert-type','danger');
        }
        
        if($validated_data["categoria_id"]>12 && $validated_data["tipo"] == 'R'){
            return redirect()->back()->with('alert-msg','Movimento não criado. Tipo e Categoria do Movimento não coincidem!')
                                     ->with('alert-type','danger');
        }
        
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
        
        //dd($validated_data);
        Movimento::create($validated_data);
        $conta->save();
        

        return redirect()->route('contas.detalhe' ,['conta'=>$conta])
            ->with('alert-msg','Movimento criada com sucesso')
           ->with('alert-type','success');
    }


    public function edit(Movimento $movimento){
        //dd($movimento->id);
        $categorias=Categoria::all();
        return view('movimentos.edit')->withCategorias($categorias)                                 
                                      ->withMovimento($movimento);
    }


    public function update(MovimentoPost $request, Movimento $movimento, Conta $conta){
        
        $validated_data =$request -> validated();
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

        //dd($movimento->contas);
        $movimento->fill($validated_data);
        $movimento->save();

        
        return redirect()->route('contas.detalhe', $movimento->conta_id)
           
            ->with('alert-msg', 'Movimento foi alterado com sucesso!')
            ->with('alert-type','success');
    }
    
}
