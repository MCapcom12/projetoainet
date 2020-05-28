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

<div class="form-group">
    <label for="inputCategoria">Categoria do Movimento</label>
    <select class="form-control" name="categoria_id" id="inputCategoria">

        <option value="" {{'' == old('categoria_id', $movimento->categoria_id) ? 'selected' : ''}}>Sem Categoria</option>

        
            @foreach ($categorias as $categ => $id)
                <option value={{$categ+1}} {{$categ+1 == old('categoria_id', $movimento->categoria_id)  ? 'selected' : ''}}>{{$id->nome}} ({{$id->tipo}})</option>
            @endforeach
        
    </select>
    @error('categoria_id')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputDescricao">Descrição do Movimento</label>
    <textarea class="form-control" name="descricao" id="inputDescricao" rows=10>{{old('descricao', $movimento->descricao)}}</textarea>
    @error('descricao')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>