@extends('layout_admin')
@section('title','Conta')

@section('content')

    <div class= "row mb-3">
        <div class="col-3">
        <a href="{{route('contas.edit',['conta'=>$conta])}}" class="btn btn-primary" role="button" aria-pressed="true">Editar</a>
        </div>

        <div class ="col-3" >
        <a href="#" class="btn btn-danger" role="button" aria-pressed="true">Eliminar</a>
        </div>
    </div>

    
  

    <table class= "table">
        <thead>
            <tr> 
                <th>nome</th>
                <th>descricao</th>
                <th>saldo abertura</th>
                <th>saldo atual</th>
             </tr>
        </thead>
        <tbody>
       
            <tr> 
                <th>{{$conta->nome}}</th>
                <th>{{$conta->descricao}}</th>
                <th>{{$conta->saldo_abertura}}</th>
                <th>{{$conta->saldo_atual}}</th>
             </tr>
            
        </tbody>


    </table>

   <div class="row mr-3">
        <div class="col-3">
        <a href="{{route('contas')}}" class="btn btn-primary" role="button" aria-pressed="true">Voltar Atrás</a>
        </div>
   </div>
    


@endsection