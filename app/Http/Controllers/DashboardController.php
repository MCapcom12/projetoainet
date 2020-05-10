<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User;


class DashboardController extends Controller
{
    public function index()
    {
        $contas = Conta::all();
        $users = User::all();
        return view('dashboard.index')->withContas($contas)
                                      ->withUsers($users);
                                      
    }

}
