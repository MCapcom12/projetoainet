<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User; 
use App\Movimento; 
use App\Categoria;
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

        //$movs=$conta->movimentos()->paginate(10);
        
        //$tipo=$conta->movimentos()->get('tipo');

        //$mov_tipo = $conta->movimentos()->where('tipo', 'D')->paginate(10);
        $categorias=$conta->movimentos()->get('categoria_id');
        //$categorias=Categoria::all()->toArray();
        //dd($categorias);

        if(request()->has('tipo') && request('tipo') != ''){
            $movimentos= $conta->movimentos()->where('movimentos.tipo','=',request('tipo'));
            //dd($movimentos);
        }
        elseif(request()->has('categoria_id') && request('categoria_id') != ''){
            $movimentos= $conta->movimentos()->where('movimentos.categoria_id','=',request('categoria_id'));
            //$movimentos=$conta->movimentos();
        }else{
            //$movimentos=$conta->movimentos();
            $movimentos=Movimento::query()->where('conta_id',$conta->id)->orderBy('data','desc')->orderBy('id','desc');
        }

        


        $movimentos = $movimentos->paginate(10);
        //dd($mov_tipo);

        //$movs =$conta->movimentos()->where('tipo', $mov_tipo)->paginate(10);
        
        //dd($movs);

        return view('contas.detalhe')
        ->withCategorias($categorias)
        ->withConta($conta)
        ->withMovimentos($movimentos);   
        //->withSelectedTipo($tipo);

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
        $validated_data['user_id'] = Auth::id();
        $validated_data['saldo_atual'] = $validated_data['saldo_abertura'];
       Conta::create($validated_data);

        return redirect()->route('contas')
            ->with('alert-msg','Conta criada com sucesso')
           ->with('alert-type','success');
    }

    public function destroy(Conta $conta){
        $oldName = $conta->nome;
        try {
            $conta->delete();
            return redirect()->route('contas')
            ->with('alert-msg', 'Conta "'.$conta->nome.'"foi apagada com sucesso')
            ->with('alert-type','success');

        } catch (\Throwable $th) {
            //throw $th;
            if ($th->errorInfo[1]=1451) {
                return redirect()->route('contas')
                ->with('alert-msg', 'Não foi possível apagar a Conta "' . $oldName . '", porque esta conta já está em uso!')
                    ->with('alert-type', 'danger');
            }else{
                return redirect()->route('contas')
                    ->with('alert-msg', 'Não foi possível apagar a Conta "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    public function lixeira(){

        $user= Auth::id();
        $contas_eliminadas = Conta::onlyTrashed()
            ->where('user_id',$user)
            ->get();
          //dd($contas_eliminadas);
        return view('contas.lixeira')
            ->withContas($contas_eliminadas);    
    }

    public function forceDelete(int  $id){
        $conta=Conta::onlyTrashed()
        ->where('id',$id);
       
        $conta->forceDelete();

        return redirect()->route('contas')
        ->with('alert-msg', 'Conta foi apagada com sucesso')
            ->with('alert-type','success');

    }

    public function restore(int $id){
        
        $conta=Conta::onlyTrashed()
            ->where('id',$id);
       
        $conta->restore();
        return redirect()->route('contas')
            ->with('alert-msg', 'Conta  foi restaurada com sucesso')
            ->with('alert-type','success');
    }
   
}
