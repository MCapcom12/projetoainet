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
        $users = $conta->utilizadores_autorizados;
        $userAuth = 0;
        foreach ($users as $utilizadores_autorizados) {
            
            if($utilizadores_autorizados->id == Auth::user()->id){
                //Se fores um utilizador autorizado
                $userAuth = 1;
                if($utilizadores_autorizados->pivot->so_leitura == 1){
                    $utilizadorLer = 1;
                }else{
                    $utilizadorLer = 0;
                }
                break;


            }
        }
        if($userAuth){
            if($utilizadorLer){
                $movimentos=Movimento::query()->where('conta_id',$conta->id)->orderBy('data','desc')->orderBy('id','desc');
                $movs=$movimentos->paginate(10);
                //$movs=$conta->movimentos()->paginate(10);
        
                return view('contas.partilhadasLer')
                    ->withConta($conta)
                    ->withMovimentos($movs);

            }else{
                $movimentos=Movimento::query()->where('conta_id',$conta->id)->orderBy('data','desc')->orderBy('id','desc');
                $movs=$movimentos->paginate(10);
                //$movs=$conta->movimentos()->paginate(10);
        
                return view('contas.partilhadasCompleto')
                    ->withConta($conta)
                    ->withMovimentos($movs);
            }
            
        //$movs=$conta->movimentos()->paginate(10);
        
        //$tipo=$conta->movimentos()->get('tipo');

        //$mov_tipo = $conta->movimentos()->where('tipo', 'D')->paginate(10);
        $categorias=$conta->movimentos()->get('categoria_id');
        //$categorias=Categoria::all()->toArray();
        //dd($categorias);

        if(request()->has('tipo') && request('tipo') != ''){
            $movimentos=Movimento::query()->where('conta_id',$conta->id)->where('movimentos.tipo','=',request('tipo'))->orderBy('data','desc')->orderBy('id','desc');
            //$movimentos= $conta->movimentos()->where('movimentos.tipo','=',request('tipo'));
            //dd($movimentos);
        }
        elseif(request()->has('categoria_id') && request('categoria_id') != ''){
            $movimentos=Movimento::query()->where('conta_id',$conta->id)->where('movimentos.categoria_id','=',request('categoria_id'))->orderBy('data','desc')->orderBy('id','desc');
            //$movimentos= $conta->movimentos()->where('movimentos.categoria_id','=',request('categoria_id'));
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

        }else{
            $categorias=$conta->movimentos()->get('categoria_id');
        //$categorias=Categoria::all()->toArray();
        //dd($categorias);

        if(request()->has('tipo') && request('tipo') != ''){
            $movimentos=Movimento::query()->where('conta_id',$conta->id)->where('movimentos.tipo','=',request('tipo'))->orderBy('data','desc')->orderBy('id','desc');
            //$movimentos= $conta->movimentos()->where('movimentos.tipo','=',request('tipo'));
            //dd($movimentos);
        }
        elseif(request()->has('categoria_id') && request('categoria_id') != ''){
            $movimentos=Movimento::query()->where('conta_id',$conta->id)->where('movimentos.categoria_id','=',request('categoria_id'))->orderBy('data','desc')->orderBy('id','desc');
            //$movimentos= $conta->movimentos()->where('movimentos.categoria_id','=',request('categoria_id'));
            //$movimentos=$conta->movimentos();
        }else{
            //$movimentos=$conta->movimentos();
            $movimentos=Movimento::query()->where('conta_id',$conta->id)->orderBy('data','desc')->orderBy('id','desc');
        }

        


        $movimentos = $movimentos->paginate(10);
            //$movs=$conta->movimentos()->paginate(10);
        
            return view('contas.detalhe')
                ->withConta($conta)
                ->withCategorias($categorias)
                ->withMovimentos($movimentos);
        } 
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

    public function auth(Conta $conta){
        $users = $conta->utilizadores_autorizados;
        foreach ($users as $utilizadores_autorizados) {
            $utilizadores_autorizados->pivot->so_leitura;
        }
        return view('contas.auth')
            ->withUsers($users)
            ->withConta($conta);
    }

    public function addUser(Request $request, Conta $conta){
        $search = $request->get('search');
        $mail = $conta->utilizadores_autorizados()->where('email', '=', $search)->first();
        if($mail){
            return redirect()->back()
                    ->with('alert-msg', 'Utilizador com email especificado já se encontra com autorizações!')
                    ->with('alert-type','danger');
        }

        //Validar o email (Ver se ele está registado)
        if(User::where('email', '=', $search)->exists()){
            $user = User::where('email', '=', $search)->first();
            //validar se o mail está verificado
            if($user->email_verified_at == null){
                return redirect()->back()
                ->with('alert-msg', 'Utilizador com email especificado não se encontra verificado!')
                ->with('alert-type','danger');
            }else{
                $id = $conta->utilizadores_autorizados();
                $id->attach($user->id, ['so_leitura' => 1]);
                return redirect()->back();
            }
            
        }else{
            return redirect()->back()
                ->with('alert-msg', 'Utilizador com email especificado não foi encontrado, tente outra vez!')
                ->with('alert-type','danger');
        }
    }

    public function removeUser(Conta $conta, User $id){
        $user = $conta->utilizadores_autorizados()->where('user_id', $id->id);
        $user->detach($id->id);

        return redirect()->back();
    }

    public function contasPartilhadas(Request $request){
        $user= $request->user();

        $contas = $user->autorizacoes_contas()->paginate(10);
        
       return view('contas.adminShared')
            ->withContas($contas);
    }

    public function changeAuth(Conta $conta, User $id){ 
        $user = $conta->utilizadores_autorizados()->where('user_id', $id->id);
       //dd($users);
                if($user->first()->pivot->so_leitura){
                    $user->updateExistingPivot($id,['so_leitura'=> 0]);
                }else{
                    $user->updateExistingPivot($id,['so_leitura'=> 1]);
                }
        return redirect()->back();
    }
}
