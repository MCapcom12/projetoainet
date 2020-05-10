@extends('layout_admin')
@section('title','FINANÇAS PESSOAIS')
@section('content')
<br>
<div>Bem vindos ao seu site de Finanças Pessoais.</div>
<div>Aqui poderá fazer a gestão das suas finanças pessoais, ou seja, registar todos os seus movimentos financeiros (receitas e despesas), fazer um sumário do estado das suas finanças e aceder a informação sobre as suas receitas e
despesas. Para além disso, apenas nós garantimos que os seus familiares o possam também fazer.</div>
<div>O nosso banco para si!!!! :)</div>

@endsection

@section('title2','ESTATÍSTICAS GERAIS')
@section('content2')

<table>
        <thead>
            <tr>
                <th>Número de Contas</th>
                <th>Número de Utilizadores</th>
                
            </tr>
        </thead>
        <tbody>
        <tr>
                <td> {{count($contas)}}</td>
                
            </tr>
        </tbody>
    </table>
@endsection