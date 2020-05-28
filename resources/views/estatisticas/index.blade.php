@extends('layout_admin')
@section('title','Estatisticas do Utilizador')
@section('content')

<div class="profile-head">
                                 
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a style="color: black;" class="nav-link active font-weight-bold" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Gráficos</a>
        </li>
        <li class="nav-item">
            <a style="color: black;" class="nav-link font-weight-bold" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Informação Textual</a>
        </li>
    </ul>
</div>

<div class="tab-content profile-tab" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <br>
        <div class = "container">
            <div class="row">
                <div class="col-6">
                     <div class="card rounded">
                        <div class="card-body py-3 px-3">
                             {!! $estatistica->container() !!}
                         </div>
                    </div>
                </div>
             </div> 
        </div>
    </div>
    <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h2>algum texto</h2>
    </div>
</div>




@endsection