@extends('layout_admin')

@section('content')

<div class="container">
	<div calss="row">
		<div class="col-md-10 col-md-offset1">
			<img src="{{$id->foto ? $path = '/storage/fotos/' . $id->id . '/' . $id->foto : asset('img/default_img.png') }}" style="width:150px;height:150px;float:left; border-radius: 50%; margin-right: 25px;">
			<h2>Perfil</h2>
			<h2>{{$id->name}}</h2>
			<label>{{$id -> email}}</label>
		</div>
	</div>
</div>

<!--
<h2>Nome: {{$id -> name}}</h2>
<h2>Email: {{$id -> email}}</h2>-->

@endsection
