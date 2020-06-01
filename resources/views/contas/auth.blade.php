@extends('layout_admin')
@section('title','Autorizações de Conta')

@section('content')

<div> 
<table class = "table">
    <thead>
        <tr>
        	<div class="col-md-4">
                <form action="{{route('contas.addUser', ['conta'=>$conta])}}"  method="get">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control">
                        <span class="input-group-prepend">
                            <button type="submit"  class="btn btn-primary">Adicionar Utilizador</button>             
                        </span>
                    </div>
                </form>
            </div>
            <th>Foto</th>
            <th>Nome</th>
            <th>Email</th>
            <th></th>
            <th></th>
            <th>Tipo de Previlégio</th>
            <th></th>
            <th>Ações</th>
            <th></th> 
            <th></th> 
        </tr>
    </thead>
    <tbody>

	@foreach($users as $id)
	    <tr>  
	    	<td> <img src="{{$id->foto ? $path = '/storage/fotos/' . $id->foto : asset('img/default_img.png') }}" style="width:50px;height:50px;float:left; border-radius: 50%; margin-right: 25px;"></td>      
	    	<td> {{$id->name}}</td>
	    	<td> {{$id->email}}</td>
	    	<td></td>
	    	<td></td>
	    	<td><?php
            if ($id->pivot->so_leitura){
                echo "Leitura";
            }else{
                echo "Acesso Completo";
            }
            ?> 
            </td>
			<td></td>
			<td><a href="{{route('contas.changeAuth', ['conta'=>$conta, 'id'=>$id])}}" class="btn btn-primary" role="button" aria-pressed="true">Alterar Previlégios</a></td>
			<td></td>
			<td><a href="{{route('contas.removeUser', ['conta'=>$conta, 'id'=>$id])}}" class="btn btn-danger" role="button" aria-pressed="true">Remover Autorização</a></td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

@endsection