@extends('layout_admin')
@section('title','Contas')

@section('content')

<table class = "table">
    <thead>
        <tr>
            <th>nome</th>
            <th>saldo atual</th> 
            <th>Nome Dono</th>
            <th>Email</th>
            <th>Tipo de Autorização</th>
            <th></th>
            
        </tr>
    </thead>
    <tbody>

    @foreach($contas as $cont)
        <tr>       
            <td> {{$cont->nome}}</td>
            <td> {{$cont->saldo_atual}}</td>
            <td> {{$cont->user->name}}</td>
            <td> {{$cont->user->email}}</td>
            <td><?php
            if ($cont->pivot->so_leitura){
                echo "Leitura";
            }else{
                echo "Acesso Completo";
            }
            ?>          
            </td>
            <td><a href="{{route('contas.detalhe', ['conta'=>$cont])}}" class="btn btn-primary btn-sm" role="button" aria-pressed ="true">Detalhe da Conta </a></td>
            
        </tr>
    @endforeach
    </tbody>
</table>

{{$contas->withQueryString()->links()}}
@endsection