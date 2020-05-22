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
}