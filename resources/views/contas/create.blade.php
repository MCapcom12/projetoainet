@extends('layout_admin')
@section('title','Nova Conta')

@section('content')
    <form method="post" action="{{route('contas.store')}}"  class="form-group">
        @csrf
        @include('contas.partials.create-edit')
        <div class="form-group text-right">
            <button type="submit" class=" btn btn-success" name="ok">Save</button>
            <a href="{{route('contas')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection