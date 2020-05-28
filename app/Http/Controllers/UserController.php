<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
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

    public function search(Request $request){
        $id = Auth::user();
        $search = $request->get('search');
        $users = User::where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->paginate(15);

        if($id->adm == 1){
            return view('users.index_adm', ['users' => $users]);
        }else{
            return view('users.index', ['users' => $users]);
        }
    }

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
}