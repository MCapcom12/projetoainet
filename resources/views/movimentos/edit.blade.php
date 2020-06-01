@extends('layout_admin')
@section('title','Alterar Movimento')
@section('content')
    <form method="POST" action="{{route('movimentos.update', ['movimento' => $movimento])}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('movimentos.partials.create-edit')
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{URL::previous()}}" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
@endsection