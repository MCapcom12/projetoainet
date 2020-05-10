<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;


class DashboardController extends Controller
{
    public function index()
    {
        $contas = Conta::all();
        return view('dashboard.index')->withContas($contas);
                                      
    }

}
