<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User;

use Illuminate\Support\Facades\Auth;

class ContaController extends Controller
{
    public function admin(Request $request){
       $user= $request->user() ;
       
       $qry= Conta::query();

       if($user){
           $qry->where('user',$user);
       }
       $contas=$qry->paginate(10);
      

       return view('contas.admin')
        ->withContas($contas);
        
        //->withSelectedUser($user);

        
    }

    public function edit(){
        return view('contas.edit');
    }

    public function create(){
        $listaUsers= User::pluck('name','id');
        return view('contas.create')->withUsers($listaUsers);
    }

    public function store(Request $request){
        $validated_data = $request->validade([
            'nome'=>'required|string|max:20'

        ]);

        Conta::create($validated_data);

        return redirect()->route('admin.disciplinas')
            ->with('alert-msg','Conta criada com sucesso')
            ->with('alert-type','success');
    }

   
}
