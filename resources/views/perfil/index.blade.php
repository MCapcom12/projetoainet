@extends('layout_admin')

@section('title','PERFIL')

@section('content')
<img src="{{$path = '/storage/fotos/' . $id->id . '/' . $id->foto}}"  alt="" style="width:300px;height:auto;float:left;">
<h2>Nome: {{$id -> name}}</h2>
<h2>Email: {{$id -> email}}</h2>

@endsection
