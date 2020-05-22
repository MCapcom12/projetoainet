@extends('layout_admin')
@section('title','UTILIZADORES')
@section('content')

<div> 
<table class = "table">
    <thead>
        <tr>
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
            <th>Foto</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th>
            <th></th>
            <th>Block</th>
            <th></th>
            <th></th>
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
            <td><?php
            if ($id->adm){
                echo "Admin";
            }else{
                echo "Regular";
            }
            ?>          
            </td>
            <td><a href="{{route('changeType', ['id'=>$id])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
            <td>
            <?php
            if ($id->bloqueado){
                echo "Blocked";
            }else{
                echo "Not Blocked";
            }
            ?> 
            </td>
            <td><a href="#" class= "btn btn-danger btn-sm">Bloquear/Desbloquear</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

{{ $users->withQueryString()->links() }}

@endsection