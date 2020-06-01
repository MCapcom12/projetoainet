@extends('layout_admin')
@section('title','Estatisticas do Utilizador')
@section('content')

<div class="row mb-3" >
    <div class="col-3">
        <a href="#" class="btn btn-primary" role="button" aria-pressed="true">Resumo das Contas</a>
    </div>

    <div class="col-3">
        <a href="#" class="btn btn-primary" role="button" aria-pressed="true">Resumo Receitas/Despesas</a>
    </div>
    
    <div class="col-3">
        <a href="#" class="btn btn-primary" role="button" aria-pressed="true">Receitas/Despesas por Categoria</a>
    </div>

    <div class="col-3">
        <a href="#" class="btn btn-primary" role="button" aria-pressed="true">Medias</a>
    </div>
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