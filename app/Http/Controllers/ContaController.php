<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User;
use App\Http\Requests\ContaPost;


use Illuminate\Support\Facades\Auth;

class ContaController extends Controller
{
    public function admin(Request $request){

      // $user= Auth::id();
       $user= $request->user() ;
      
       $qry= Conta::query();

       if($user){
           $qry->where('user_id',$user->id);
       }
       $contas=$qry->paginate(10);
      

       return view('contas.admin')
        ->withContas($contas);
    }

    public function detalhe(Conta $conta){
        
        
        return view('contas.detalhe')
        ->withConta($conta);
    }

    public function edit(){
        return view('contas.edit');
    }

    public function create(){
        $user= Auth::id();
       // dd($user);
        return view('contas.create')->withUser($user);
    }

    public function store(ContaPost $request){
        
        $validated_data = $request->validated();
        
       Conta::create($validated_data);

        return redirect()->route('contas')
            ->with('alert-msg','Conta criada com sucesso')
            ->with('alert-type','success');
    }

   
}
