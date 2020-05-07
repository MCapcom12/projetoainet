<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;

class ContaController extends Controller
{
    public function admin(){
        $contas = Conta::all();
        return view('contas.admin')->withContas($contas);
    }
}
