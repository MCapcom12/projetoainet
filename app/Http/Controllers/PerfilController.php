<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
    	$id = Auth::user();
        return view('Perfil.index')->withId($id);                     
    }
}
