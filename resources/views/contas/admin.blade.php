@extends('layout_admin')
@section('title','Contas')

@section('content')
<div class= "row mb-3">
    <div class="col-3">
        <a href="{{route('admin.contas.create')}}" class="btn btn-success" role="button" aria-pressed="true">Nova Conta</a>
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('admin.contas')}}" class="form-group">
            <div class="input-group">
                <Select class="custom-select" name="user" id="inputUser" aria-label="User">
                    <option value= "" {{''== old('user_id', $selectedUser) ? 'selected' : '' }}>Todos Users</option>
                    @foreach($users as $abr => $name)
                    <option value={{$abr}} {{$abr== old('user_id', $selectedUser) ? 'selected' : ''}}>{{$name}}</option>
                    @endforeach
                </Select>
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
            <th>id</th>          
            <th>nome</th>            
            <th>saldo atual</th> 
            <th></th>
            <th></th>           
        </tr>
    </thead>
    <tbody>
    @foreach($contas as $cont)
        <tr>   
            <td>{{$cont->id}}</td>         
            <td> {{$cont->nome}}</td>
            <td> {{$cont->saldo_atual}}</td>
            <td><a href="{{route('admin.contas.edit', ['id' =>$cont->id])}}" class="btn btn-primary btn-sm" role="button" aria-pressed ="true">Alterar </a></td>
            <td>
                <a href="#" class= "btn btn-danger btn-sm">Apagar(Ainda por fazer)</a> 
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{$contas->withQueryString()->links()}}
@endsection