<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    public function index()
    {
        return view('Movimentos.index');                                     
    }

}
