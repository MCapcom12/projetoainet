@extends('layout_admin')

@section('content')
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>user_id</th>
                <th>nome</th>
                <th>descricao</th>
                <th>saldo abertura</th>
                <th>saldo atual</th>
                <th>data ultimo movimento</th>
                <th>delete at</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contas as $cont)
            <tr>
                <td> {{$cont->id}}</td>
                <td> {{$cont->user_id}}</td>
                <td> {{$cont->nome}}</td>
                <td> {{$cont->descricao}}</td>
                <td> {{$cont->saldo_abertura}}</td>
                <td> {{$cont->saldo_atual}}</td>
                <td> {{$cont->data_ultimo_movimento}}</td>
                <td> {{$cont->delete_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection