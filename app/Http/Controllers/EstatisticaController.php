<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\EstatisticaChart;
use App\Conta;
use App\Movimento;
use DB;


use Illuminate\Support\Facades\Auth;

class EstatisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index(Request $request)
    {
        //

        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"

        ];
        $user_id=Auth::id();
        //$contas = DB::table('contas')->select('saldo_atual')->where('user_id',$user_id)->get();
        $contas= Conta::where('user_id',$user_id)->get();

        $saldo_total=$contas->sum('saldo_atual');

        //dd($contas->values());
        //dd($saldo_total);

        $totalSaldo= new EstatisticaChart;


        //(saldoatualconta/totalsaldo)*100
        
       // 
            $i=0;//variavel para percorrer vetor de cores
            foreach($contas as $conta){
                $saldo_percentagem=(($conta->saldo_atual)/$saldo_total)*100;
                $saldo_percentagem=number_format($saldo_percentagem,2,'.','');
                
                $totalSaldo->dataset($conta->nome,'bar',[$saldo_percentagem])
                ->color($borderColors[$i])
                ->backgroundcolor($fillColors[$i]);
               $i++;
            }

            //total receitas/despesas por periodo de tempo

            $totalValoresTempo = new EstatisticaChart;
            $j=0;//variavel para percorrer vetor de cores
            foreach($contas as $conta){

                
               $receitas=Movimento::where([['conta_id',$conta->id],['tipo','R']])
                ->sum('valor');

                $despesas=Movimento::where([['conta_id',$conta->id],['tipo','D']])->sum('valor');
                
                $total= $receitas-$despesas;
              

              // dd($movs->values());
             
              $totalValoresTempo->labels(['Receitas', 'Despesas', 'Total']);
              $totalValoresTempo->dataset($conta->nome, 'bar', [$receitas, $despesas, $total])
              ->color($borderColors[$j])
                ->backgroundcolor($fillColors[$j]);
               $j++;    
            }

            //grafico cat por mes
/*
             $graphCat= new EstatisticaChart;

          
           
            
             foreach($contas as $conta){
                $RecCategorias= Movimento::select('movimentos.categoria_id',DB::raw('movimentos.categoria_id', "receitas nao classificadas"),DB::raw("sum(movimentos.valor)"))
                ->leftjoin('categorias', 'categorias.id', '=','movimentos.categoria_id')
                    ->where('movimentos.tipo','R')
                    ->groupBy('movimentos.categoria_id')
                    ->get();
                 $DesCategoria  = Movimento::select('movimentos.categoria_id',DB::raw('movimentos.categoria_id', "despesas nao classificadas"),DB::raw("sum(movimentos.valor)"))
                ->leftjoin('categorias', 'categorias.id', '=','movimentos.categoria_id')
                ->where('movimentos.tipo','D')
                ->groupBy('movimentos.categoria_id')
                ->get();  
                

                //dd($RecCategorias);
                //dd($DesCategoria);

                $valor=$RecCategorias->sum('movimentos.valor');
                
                
                    

              $graphCat->dataset($conta->nome,'bar',[$valor]);      
            } 
    */
            

           



           
        
         
        

       


        
        return view('estatisticas.index',compact('totalSaldo','totalValoresTempo'));
    }


    

  


    
    
   
}
