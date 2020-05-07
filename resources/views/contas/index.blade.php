@extends('layout_admin')

@section('content')
    <h2>Contas</h2>
    <form class="disc-search" action="#" method="GET">
        <div class="search-item">
            <label for="idUser">Uuser:</label>
            <select name="user" id= "idUser">
                @foreach($contas as $abr=> $nome)
                    <option value="{{$abr}}" {{$abr ==$user ? 'selected' : '' }}>{{$nome}}</option>

                @endforeach
            </select>
        </div>
        <div class= "Search-item">
            <button type="submit" class="bt" id="btn-filter">Filtrar</button>
        </div>
    </form>
    <div class="show-area">
        

@endsection