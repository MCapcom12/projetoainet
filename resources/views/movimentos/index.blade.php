@extends('layout_admin')
@section('title','MOVIMENTOS')
@section('content')

<div class= "row mb-3">
    <div class="col-3">
        <a href="#" class="btn btn-success" role="button" aria-pressed="true">Novo Movimento</a>
    </div>
    
</div> 
<table class = "table">
    <thead>
        <tr>
            <th>Conta_id</th>
            <th>Data do Movimento</th>
            <th>Valor</th>
            <th>Saldo Inicial</th> 
            <th>Saldo Final</th>
            <th>Categoria do Movimento</th>
            <th>Tipo do Movimento</th>  
        </tr>
    </thead>
    <tbody>
    @foreach($movimentos as $mov)
        <tr>  
        <td>{{$mov->conta_id}}</td>  
            <td>{{$mov->data}}</td>         
            <td> {{$mov->valor}}</td>
            <td> {{$mov->saldo_inicial}}</td>
            <td> {{$mov->saldo_final}}</td>
            <td> {{$mov->categoria_id}}</td>
            <td> {{$mov->tipo}}</td>
            <td><a href="#" class="btn btn-primary btn-sm" role="button" aria-pressed ="true">Alterar </a></td>
            <td>
                <a href="#" class= "btn btn-danger btn-sm">Apagar(Ainda por fazer)</a> 
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$movimentos->withQueryString()->links()}}

@endsection

