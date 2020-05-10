<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function admin(){
        $users = User::all();
        return view('users.admin')->withUsers($users);

        
    }
}