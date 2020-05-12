<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\User;
use App\Movimento;

class DashboardController extends Controller
{
    public function index()
    {
        $contas = Conta::all();
        $users = User::all();
        $movs = Movimento::count();
        return view('dashboard.index')->withContas($contas)
                                      ->withUsers($users)
                                       ->withMovimentos($movs);
                                      
    }

}
