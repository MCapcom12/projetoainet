<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = DB::table('users')->paginate(15);
        return view('users.index')->withUsers($users);
    }

    public function search(Request $request){
    	$search = $request->get('search');
    	$users = DB::table('users')->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->paginate(5);
    	return view('users.index', ['users' => $users]);
    }
}