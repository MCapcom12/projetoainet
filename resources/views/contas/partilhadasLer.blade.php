@extends('layout_admin')
@section('title','Conta')

@section('content')

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

    <div  class= "text-center">
        <h1 >Movimentos Da Conta</h1>
    </div>

    <table class = "table">
        <thead>
            <tr>
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
                <td>{{$mov->data}}</td>         
                <td> {{$mov->valor}}</td>
                <td> {{$mov->saldo_inicial}}</td>
                <td> {{$mov->saldo_final}}</td>
                <td> {{$mov->categoria_id}}</td>
                <td> {{$mov->tipo}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

   


   <div class="row mr-3">
   {{$movimentos->withQueryString()->links()}}
        <div class="ml-auto" >
            <a href="{{route('contasPartilhadas')}}" class="btn btn-primary" role="button" aria-pressed="true">Voltar Atrás</a>
        </div>
   </div>
    
   


@endsection




