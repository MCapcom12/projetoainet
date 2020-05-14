@extends('layout_admin')
@section('title','UTILIZADORES')
@section('content')

</div> 
<table class = "table">
    <thead>
        <tr>
            <th>id</th>
            <th>nome</th>
            <th>email</th> 
            <th></th>
            <th></th> 
            <th></th> 
        </tr>
    </thead>
    <tbody>
    @foreach($users as $id)
        <tr>   
            <td>{{$id->id}}</td>         
            <td>{{$id->name}}</td>
            <td>{{$id->email}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

@endsection