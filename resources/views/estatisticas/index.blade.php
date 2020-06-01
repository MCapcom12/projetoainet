@extends('layout_admin')
@section('title','Estatisticas do Utilizador')
@section('content')

<div class="text-center">
<h1>Saldo Total</h1>
</div>

<div>
<br>
<h3> Aqui consegue ver o peso em percentagem de cada conta no somatorio das suas contas</h3>
<br>
</div>


<div class = "container">
            <div class="row">
                <div class="col-6">
                     <div class="card rounded">
                        <div class="card-body py-3 px-3">
                            
                             {!! $totalSaldo->container() !!}
                         </div>
                    </div>
                </div>
             </div> 
        </div>
   <br>
@endsection
@section('title2','Receitas/Despesas Por Conta')
@section('content2')
<br>

<div>
<br>
<h3> Aqui consegue ver o valor da receita e despesa por conta. Na aba Total mostra a diferença entre as receitas e a despesas! </h3>
<br>
</div>

        <div class = "container">
            <div class="row">
                <div class="col-6">
                     <div class="card rounded">
                        <div class="card-body py-3 px-3">
                        {!! $totalValoresTempo->container() !!}
                         </div>
                    </div>
                </div>
             </div> 
        </div>

        

       



@endsection