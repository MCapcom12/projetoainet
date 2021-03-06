@extends('layout_admin')
@section('title','Novo Movimento')

@section('content')
    <form method="post" action="{{route('movimentos.store', ['conta'=>$conta->id])}}"  class="form-group" enctype="multipart/form-data">
        @csrf
        @include('movimentos.partials.create-edit')
        <div class="form-group text-right">
           
            <button type="submit" class=" btn btn-success" name="ok">Save</button>
            
            <a href="{{route('contas.detalhe',['conta'=>$conta])}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection