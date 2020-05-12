@extends('layout_admin')

@section('title','PERFIL')

@section('content')
<img src="{{$path = '/storage/fotos/' . $id->id . '/' . $id->foto}}"  alt="" style="width:300px;height:auto;">

<td>{{$id -> name}}</td>
<td>{{$id -> email}}</td>
<!--
<table>
 <thead>
 <tr>
 <th>Curso</th>
 <th>Ano</th>
 <th>Sem.</th>
 <th>Abr.</th>
 <th>Nome</th>
 <th>ECTS</th>
 <th>Horas</th>
 <th>Opcional</th>
 </tr>
 </thead>
 <tbody>

 </tbody>
 </table>
-->
@endsection
