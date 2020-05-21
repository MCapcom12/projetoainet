<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User; 
use App\Movimento; 
use App\Http\Requests\ContaPost;


use Illuminate\Support\Facades\Auth;

class ContaController extends Controller
{
    public function admin(Request $request){

      // $user= Auth::id();
       $user= $request->user() ;
      
       $qry= Conta::query();
       //dd($qry);

       if($user){
           $qry->where('user_id',$user->id);
       }
       $contas=$user->contas()->paginate(10);
      //dd($contas);

       return view('contas.admin')
        ->withContas($contas);
    }

    public function detalhe(Conta $conta){ 

        $movs=$conta->movimentos()->paginate(10);

        return view('contas.detalhe')
        ->withConta($conta)
        ->withMovimentos($movs);

    }

    public function edit(Conta $conta){
        
        return view('contas.edit')->withConta($conta);
    }

    public function update(ContaPost $request, Conta $conta){
        $validated_data =$request -> validated();
        $conta->fill($validated_data);
        $conta->save();

        

        return redirect()->route('contas.detalhe',['conta'=>$conta])
           
            ->with('alert-msg', 'Conta "' .$conta->nome. '"foi alterada com sucesso!')
            ->with('alert-type','success');
        }

    public function create(){
        $user= Auth::id();
       $newConta= new Conta;
        return view('contas.create')->withUser($user)
        ->withConta($newConta);
    }

    public function store(ContaPost $request){
        
       
        
        $validated_data = $request->validated();
       Conta::create($validated_data);

        return redirect()->route('contas')
            ->with('alert-msg','Conta criada com sucesso')
           ->with('alert-type','success');
    }

   
}
