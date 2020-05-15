@extends('layout_admin')
@section('title','Contas')

@section('content')

<div class= "row mb-3">
    <div class="col-3">
        <a href="{{route('contas.create')}}" class="btn btn-success" role="button" aria-pressed="true">Nova Conta</a>
    </div>
    
</div> 
<table class = "table">
    <thead>
        <tr>
            <th>id</th>
            <th>nome</th>
            <th>saldo atual</th> 
            <th></th>
            
        </tr>
    </thead>
    <tbody>
    @foreach($contas as $cont)
        <tr>   
            <td>{{$cont->id}}</td>         
            <td> {{$cont->nome}}</td>
            <td> {{$cont->saldo_atual}}</td>
            <td><a href="{{route('contas.detalhe', ['conta'=>$cont])}}" class="btn btn-primary btn-sm" role="button" aria-pressed ="true">Detalhe da Conta </a></td>
            
        </tr>
    @endforeach
    </tbody>
</table>

{{$contas->withQueryString()->links()}}
@endsection