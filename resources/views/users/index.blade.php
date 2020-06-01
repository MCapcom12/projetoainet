@extends('layout_admin')
@section('title','UTILIZADORES')
@section('content')

@if (session('alert'))
    <div class="alert alert-warning">
        {{ session('alert') }}
    </div>
@endif

<div> 
<table class = "table">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>Email</th> 
            <div class="col-md-4">
                <form action="/search" method="get">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control">
                        <span class="input-group-prepend">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <th></th>
            <th></th> 
            <th></th> 
        </tr>
    </thead>
    <tbody>
    @foreach($users as $id)
        <tr>   
            <td><img src="{{$id->foto ? $path = '/storage/fotos/' . $id->foto : asset('img/default_img.png') }}" style="width:50px;height:50px;float:left; border-radius: 50%; margin-right: 25px;"></td>         
            <td>{{$id->name}}</td>
            <td>{{$id->email}}</td>
            <td><a href="{{route('authConta', $id)}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Autorizações</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

{{ $users->withQueryString()->links() }}

@endsection