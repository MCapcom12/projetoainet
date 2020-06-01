@extends('layout_admin')
@section('title','Estatisticas do Utilizador')
@section('content')



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