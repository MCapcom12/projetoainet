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
        $users = DB::table('users')->paginate(15);
        if($id->adm == 1){
        	return view('users.index_adm')->withUsers($users);
        }else{
        	return view('users.index')->withUsers($users);
        }  
    }

    public function search(Request $request){
        $id = Auth::user();
        $search = $request->get('search');
        $users = DB::table('users')->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->paginate(15);
        if($id->adm == 1){
            return view('users.index_adm', ['users' => $users]);
        }else{
            return view('users.index', ['users' => $users]);
        }
    }

    public function adminChangeType(User $id){
        dd($id->name);
        if(Auth::user()==$id){
            //erro
        }else{
            if($id->adm == 1){
                //$id->adm = $noadm;
                dd('sucesso');
            }else{
                //$id->adm = $adm;
                dd('insucesso');
        }
        
        $id->save();
        
        }

        return redirect()->back();
    }

    public function adminChangeBlock(Request $request){
        return redirect()->back();
    }
}