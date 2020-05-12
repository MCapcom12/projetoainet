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

<br>
<br>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;

}
th{
  padding: 15px;
  text-align: left;
  background-color:#4169E1;
  color:white;
  text-align:center;
}

td{
  padding: 15px;
  text-align:center;
}

</style>


<table style="width: 100%">
        <thead>
            <tr>
                <th>Número de Contas</th>
                <th>Número de Utilizadores</th>
                <th>Total de movimentos</th>
            </tr>
        </thead>
        <tbody>
        <tr>
                <td> {{count($contas)}}</td>
                <td> {{count($users)}}</td>
                <td> {{$movimentos}}</td>
            </tr>
        </tbody>
    </table> 








    <!-- <div class="row">
  <div class="column" style="">
    <h2>Número de Contas</h2>
    <p>{{count($contas)}}</p>
  </div>
  <div class="column" style="">
    <h2>Número de Utilizadores</h2>
    <p>{{count($users)}}</p>
  </div>
  <div class="column" style="">
    <h2>Column 3</h2>
    <p>Some text..</p>
  </div>
</div> -->
@endsection