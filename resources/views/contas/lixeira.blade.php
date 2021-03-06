@extends('layout_admin')
@section('title','Contas Eliminadas')

@section('content')

  

    <table class ="table">
    
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($contas as $cont)
            <tr>
                <th>{{$cont->id}}</th>
                <th>{{$cont->nome}}</th>
                <th>
                    <form method="POST" action="{{route('contas.restore',['id'=>$cont->id])}}">
                    @csrf
                    <button type="submit" class="btn btn-info">Restaurar</button>
                    </form>
                </th>
                <th>
                <form method="POST" action="{{route('contas.forceDelete',['id'=>$cont->id])}}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </th>
            </tr>
        @endforeach    
        

        </tbody>
    
    </table>  
               
    <div class="row mr-3">
        <div class="ml-auto">
            <a href="{{route('contas')}}" class="btn btn-primary" role="button" aria-pressed="true">Voltar Atras</a>
        </div>

    </div>




@endsection