@extends('layout_admin')
@section('title','Conta')

@section('content')

    <div class= "row mb-3">
        <div class="col-3">
            <a href="{{route('contas.edit',['conta'=>$conta])}}" class="btn btn-primary" role="button" aria-pressed="true">Editar</a>
        </div>

        <div class ="col-3" >
            <form action="{{route('contas.destroy', ['conta' => $conta])}}" method="POST">
                @csrf
                @method("DELETE")
                <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
            </form>
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

    <div  class= "text-center">
        <h1 >Movimentos Da Conta</h1>
    </div>


    <div class= "row mb-3">
        <div class="col-3">
            <a href="{{route('movimentos.create', ['conta' => $conta->id])}}" class="btn btn-success" role="button" aria-pressed="true">Novo Movimento</a>
        </div>
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
                <td><a href="{{route('movimentos.edit', ['movimento'=>$mov->id])}} " class="btn btn-primary btn-sm" role="button" aria-pressed ="true">Alterar </a></td>
                <td>
                    <a href="#" class= "btn btn-danger btn-sm">Apagar(Ainda por fazer)</a> 
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

   


   <div class="row mr-3">
   {{$movimentos->withQueryString()->links()}}
        <div class="ml-auto" >
            <a href="{{route('contas')}}" class="btn btn-primary" role="button" aria-pressed="true">Voltar Atrás</a>
        </div>
   </div>
    
   


@endsection




