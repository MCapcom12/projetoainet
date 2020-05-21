<div class="form-group">
    <label for="inputData">Data do Movimento</label>
    <input type="text" class="form-control" name="data" id="inputData" value="{{old('data',$movimento->data)}}"/>
    @error('data')
    <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
      <label for="inputValor">Valor do Movimento</label>
      <input type="text" class="form-control" name="valor" id="inputValor" value="{{old('valor',$movimento->valor)}}"/>
      @error('valor')
    <div class="small text-danger">{{$message}}</div>
    @enderror

</div>

<div class="form-group">
    <div>Tipo do Movimento</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="inputTipoD" name="tipo" value="D" {{old('tipo', $movimento->tipo) == 'D' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputTipoD"> Despesa </label>
        <input type="radio" class="form-check-input ml-4" id="inputTipoR" name="tipo" value="R" {{old('tipo', $movimento->tipo) == 'R' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputTipoR"> Receita </label>
    </div>
    @error('tipo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>