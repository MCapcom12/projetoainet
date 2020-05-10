@extends('layout_admin')
@section('title','Alterar Disciplina' )
@section('content')
    <form method="GET" action="#" class="form-group">
        @csrf
        @method('PUT')
        @include('contas.partials.create-edit')
        <div class="form-group text-right">
            <button type="submit" class="btn btn-sucsess" name="ok">Save</button>
            <a href="#" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
@endsection
