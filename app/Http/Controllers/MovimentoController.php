<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimento;


class MovimentoController extends Controller
{
    public function index()
    {
        $movs = Movimento::count();
         return view('Movimentos.index');                                  
    }

}
