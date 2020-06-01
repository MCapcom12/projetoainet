@extends('layout_admin')
@section('title','Saldo total')
@section('content')
<div class = "container">
    <div class="row">
        <div class="col-6">
            <div class="card rounded">
                <div class="card-body py-3 px-3">
                    {!! $totalSaldo->container() !!}
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection