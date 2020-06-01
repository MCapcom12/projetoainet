@extends('layout_admin')
@section('title','CONTAS')
@section('content')

<div> 
<table class = "table">
    <thead>
        <tr>
            <th>Conta</th>
            <th></th>
            <th>Autorização Atual</th>
            <th></th>
            <th>Autorização Leitura</th>
            <th>Autorização Acesso Completo</th> 
            <th></th> 
        </tr>
    </thead>
    <tbody>

	@foreach($contas as $cont)
	    <tr>      
	    	<td> {{$cont->nome}}</td>
	    	<td></td>
            <td>ÃUTH</td>
	    	<td></td>
	    	<td><a href="{{route('authUser', ['user'=>$user, 'conta'=>$cont])}}" class="btn btn-danger" role="button" aria-pressed="true">Read</a></td>
	    	<td><a href="{{route('authUser', ['user'=>$user, 'conta'=>$cont])}}" class="btn btn-danger" role="button" aria-pressed="true">Complete Access</a></td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>

@endsection