<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Conta;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $id = Auth::user();
        $users = User::paginate(15);
        if($id->adm == 1){
        	return view('users.index_adm')->withUsers($users);
        }else{
        	return view('users.index')->withUsers($users);
        }
    }

    //Funcao para fazer search na lista de utilizadores
    public function search(Request $request){
        //Vai ver qual e o utilizador autenticado para saber se e adm ou nao
        $id = Auth::user();
        $search = $request->get('search');

        //Vai procurar nos nomes e nos emails a procura
        $users = User::where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->paginate(15);

        //Se for adm, mostra o user.index_adm senao, mostra users.index
        if($id->adm){
            return view('users.index_adm', ['users' => $users]);
        }else{
            return view('users.index', ['users' => $users]);
        }
    }

    //Funcao para mudar o tipo de conta para adm ou nao, consoante o proprio tipo da conta a ser mudada
    public function adminChangeType(User $user){
        if(Auth::user()==$user){
            return redirect()->back()->with('alert', 'O utilizador não pode alterar o tipo de conta do próprio utilizador!');
        }else{
            if($user->adm == 1){
                $user->adm = 0;
            }else{
                $user->adm = 1;
        }
        
        $user->save();
        
        }

        return redirect()->back();
    }

    //Funcao para mudar o estado de conta para bloqueado ou desbloqueado, consoante o proprio estado da conta a ser mudada
    public function adminChangeBlock(User $user){
        if(Auth::user()==$user){
            return redirect()->back()->with('alert', 'O utilizador não pode bloquear/desbloquear o próprio utilizador!');
        }else{
            if($user->bloqueado == 1){
                $user->bloqueado = 0;
            }else{
                $user->bloqueado = 1;
        }
        
        $user->save();
        
        }

        return redirect()->back();
    }

    //Funcao para mostrar as contas do utilizador autenticado para dar autorizacoes
    public function authConta(User $user){
        //verificar se está verificado
        if($user->email_verified_at == null){
            return redirect()->back()->with('alert', 'O utilizador não está verificado!');
        }else{
            //verificar se o user é o mesmo que o que está logado
            if(Auth::user()->email == $user->email){
                return redirect()->back()->with('alert', 'Não pode adicionar uma autorização ao dono da conta!');
            }else{

                $id = Auth::user();
                //mostra as contas todas
                $qry= Conta::query();

                if($id){
                    $qry->where('user_id',$id->id);
                }

                $contas=$id->contas()->paginate(10);

                return view('users.auth')
                    ->withContas($contas)
                    ->withUser($user);
            }
        }
    }

    //Funcao para dar autorizacoes de Read Only
    public function authUserRead(User $user, Conta $conta){
        //Verificar se tem alguma auth
        $temp = $conta->utilizadores_autorizados()->where('user_id', $user->id)->first();
        //$temp = 1 when no auth , $temp = 0 when auth
        if($temp){
            $temp = $conta->utilizadores_autorizados()->where('user_id', $user->id);
            $temp->updateExistingPivot($user,['so_leitura'=> 1]);
            return redirect()->back()
                ->with('alert-msg', 'Autorização de leitura realizada com sucesso!')
                ->with('alert-type','success');
        }else{
            $id = $conta->utilizadores_autorizados();
            $id->attach($user->id, ['so_leitura' => 1]);
            return redirect()->back()
                ->with('alert-msg', 'Autorização de leitura realizada com sucesso!')
                ->with('alert-type','success');
        }
    }

    //Funcao para dar autorizacoes Completas
    public function authUserComplete(User $user, Conta $conta){
        //Verificar se tem alguma auth
        $temp = $conta->utilizadores_autorizados()->where('user_id', $user->id)->first();
        //$temp = 1 when no auth , $temp = 0 when auth
        if($temp){
            $temp = $conta->utilizadores_autorizados()->where('user_id', $user->id);
            $temp->updateExistingPivot($user,['so_leitura'=> 0]);
            return redirect()->back()
                ->with('alert-msg', 'Autorização de acesso completo realizado com sucesso!')
                ->with('alert-type','success');

        }else{
            $id = $conta->utilizadores_autorizados();
            $id->attach($user->id, ['so_leitura' => 0]);
            return redirect()->back()
                ->with('alert-msg', 'Autorização de acesso completo realizado com sucesso!')
                ->with('alert-type','success');
        }
    }

    //Funcao para remover qualquer autorizacao
    public function authUserRemove(User $user, Conta $conta){
        $temp = $conta->utilizadores_autorizados()->where('user_id', $user->id)->first();
        //$temp = 1 when no auth , $temp = 0 when auth
        if($temp){
            $id = $conta->utilizadores_autorizados()->where('user_id', $user->id);
            $id->detach($user->id);
            return redirect()->back()
                ->with('alert-msg', 'Autorização apagada com sucesso!')
                ->with('alert-type','success');
        }else{
            return redirect()->back()
                ->with('alert-msg', 'Utilizador especificado não tem autorizações para apagar!')
                ->with('alert-type','danger');
        }
    }
}