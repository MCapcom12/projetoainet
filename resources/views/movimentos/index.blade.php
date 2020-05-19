@extends('layout_admin')
@section('title','MOVIMENTOS')
@section('content')

<div class= "row mb-3">
    <div class="col-3">
        <a href="#" class="btn btn-success" role="button" aria-pressed="true">Novo Movimento</a>
    </div>

    <div class="col-9">
        <form method="GET" action="{{route('movimentos')}}" class="form-group">
            <div class="input-group">
            <select class="custom-select" name="conta" id="inputConta" aria-label="Conta">
                <option value="" {{request('conta') == '' ? 'selected' : ''}}>Todas Contas</option>
                @foreach ($contas as $abr => $conta)
                <option value={{$conta->id}} {{request('conta') == $conta->id ? 'selected' : ''}}>{{$conta->nome}}</option>
                @endforeach
                
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
            </div>
            </div>
        </form>
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

