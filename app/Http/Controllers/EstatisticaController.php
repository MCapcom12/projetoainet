<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\UserChart;
use App\Conta;
use DB;

use Illuminate\Support\Facades\Auth;

class EstatisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id=Auth::id();
        $contas = DB::table('contas')->select('saldo_atual')->where('user_id',$user_id)->get();

        $saldo_total=$contas->sum('saldo_atual');

        //dd($saldo_total);

        $estatistica= new UserChart;
        $estatistica->labels(['jan','fev','Mar']);
        $estatistica->dataset('User by trimester','bar',[10,25,13]);
        return view('estatisticas.index',['estatistica'=>$estatistica]);
    }

    
   
}
