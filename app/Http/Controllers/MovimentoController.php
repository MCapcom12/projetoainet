<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Movimento;
use App\Conta;
use App\Categoria;
use App\Http\Requests\MovimentoPost;
use File;


use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index(Request $request)
    {
        $user= $request->user();

        if(request()->has('conta') && request('conta') != ""){
            $movs = $user->movimentos()->where('conta_id', request('conta'))->paginate(10); 
        }else{
            $movs = $user->movimentos()->paginate(10);
        }

        $contas=$user->contas;

         //$movs=$user->movimentos()->paginate(10);
         //$movs = Movimento::paginate(15);
        // $contas_id = collect();
         
        
        // //dd(Movimento::where('conta_id',4427)->get());
        //  foreach ($contas as $conta){
            
        //         $contas_id->push($conta->id);

        //  }
         
        //  $movs=Movimento::whereIn('conta_id',$contas_id)->paginate(10);
         //$movs->paginate(10);
        $selectedConta= Conta::groupBy('nome')->pluck('nome')->toArray(); 
        //dd($selectedConta);

         return view('movimentos.index')->withMovimentos($movs)
                                        ->withContas($contas)
                                        ->withSelectedConta($selectedConta);                        
    }


    public function create(Conta $conta){

        $categorias=Categoria::all();
        $newMovimento= new Movimento;
        return view('movimentos.create')->withConta($conta)
                                        ->withCategorias($categorias)
                                        ->withMovimento($newMovimento);
    }



    public function store(MovimentoPost $request, Conta $conta){

        dd($conta->movimentos()->get('data'));
        $validated_data = $request->validated();
        if($validated_data["categoria_id"]>0 && $validated_data["categoria_id"] <= 12 && $validated_data["tipo"] == 'D'){
            return redirect()->back()->with('alert-msg','Movimento não criado. Tipo e Categoria do Movimento não coincidem!')
                                     ->with('alert-type','danger');
        }
        
        if($validated_data["categoria_id"]>12 && $validated_data["tipo"] == 'R'){
            return redirect()->back()->with('alert-msg','Movimento não criado. Tipo e Categoria do Movimento não coincidem!')
                                     ->with('alert-type','danger');
        }
        
        

        $validated_data["conta_id"]=$conta->id;
        $validated_data['saldo_inicial']=$conta->saldo_atual;
        
        //dd($validated_data['saldo_inicial']);
        if($validated_data["tipo"]=='D'){
            $validated_data["saldo_final"]= $validated_data["saldo_inicial"]-$validated_data['valor'];
        
        }else{
            $validated_data["saldo_final"]= $validated_data["saldo_inicial"]+$validated_data['valor'];      
            //dd($validated_data["saldo_final"]);
        }

        //dd($conta->movimentos->get('id'));
        if(request()->hasFile('imagem_doc')){
            $foto = $validated_data["valor"] . '_' . request()->file('imagem_doc')->getClientOriginalName();
            request()->file('imagem_doc')->storeAs('docs', $foto, '');
            $validated_data["imagem_doc"]=$foto;
        }
            //dd($validated_data["imagem_doc"]);


        $conta->saldo_atual=$validated_data["saldo_final"];
        //dd($conta->saldo_atual);
        
        //dd($validated_data);
        Movimento::create($validated_data);
        $conta->save();
        //$this->calcularSaldos($movimento->contas, $movimento);
        

        return redirect()->route('contas.detalhe' ,['conta'=>$conta])
            ->with('alert-msg','Movimento criada com sucesso')
           ->with('alert-type','success');
    }


    public function edit(Movimento $movimento){
        $categorias=Categoria::all();
        return view('movimentos.edit')->withCategorias($categorias)                                 
                                      ->withMovimento($movimento);
    }


    public function update(MovimentoPost $request, Movimento $movimento){
        //dd($movimento);
        $validated_data =$request -> validated();
        //$validated_data["conta_id"]=$movimento->id;
        //dd($movimento->saldo_final);
        $validated_data['saldo_inicial']=$movimento->saldo_final;
        //dd($validated_data['saldo_inicial']);
        if($validated_data["tipo"]=='D'){
            $validated_data["saldo_final"]= $validated_data["saldo_inicial"]-$validated_data['valor'];
        
        }else{
            $validated_data["saldo_final"]= $validated_data["saldo_inicial"]+$validated_data['valor'];      
            //dd($validated_data["saldo_final"]);
        }

        //dd($movimento->imagem_doc);

        if(request()->hasFile('imagem_doc')){
            $fotoDelete = $movimento->imagem_doc;
            //dd($fotoDelete);
            Storage::delete('docs' . '/' . $fotoDelete);
            $foto = $movimento->valor . '_' . request()->file('imagem_doc')->getClientOriginalName();
            request()->file('imagem_doc')->storeAs('docs', $foto, '');
            $movimento->update(['imagem_doc' => $foto]);
            
        }


        //$this->calcularSaldos($movimento->contas, $movimento);
        //$conta->saldo_atual=$validated_data["saldo_final"];

        //dd($movimento->contas);
        $movimento->fill($validated_data);
        $movimento->save();
        

        
        return redirect()->route('contas.detalhe', $movimento->conta_id)
           
            ->with('alert-msg', 'Movimento foi alterado com sucesso!')
            ->with('alert-type','success');
    }
    
    
    private function calcularSaldos(Conta $conta, Movimento $movimento){
        //$ultimoMovimentoValido=Movimento::where conta_id = x , data < $movimento->data 
        // $ultimoMovimentoValido=Movimento::where('conta_id', '=', $conta->id)
        //                                  ->where('data', '<', $movimento->data)
        //                                  ->orderBy('data','desc')
        //                                  ->orderBy('id','desc');
        //dd($ultimoMovimentoValido);
        
        
        //$conta->first();
        //$ultimoMovimentoValido->first();        
        //Order By data, desc
        //Order by id, desc 
        //->First() -> valor inicial da conta, caso seja null vou buscar à conta
     
        // foreach($conta->movimentos() as $mov){
        //     if($mov->get('data')>=$movimento->data){

        //     }
        // }


        //$movimentosParaAlterar = Movimento::where conta_id=x , data > $movimento-> data
        //Order By data, asc
        //ORder by id, asc
        //->get() -> buscar todos


    } 

    public function destroy(Movimento $movimento){
        //dd($movimento);
        //dd($movimento->valor);
        
        //dd($conta);
        $oldId = $movimento->id;

        try {
            
            $conta=$movimento->contas;
            $saldo= $conta->saldo_atual;
            //dd($saldo);
            if($movimento->tipo=='R'){
                $conta->saldo_atual = $saldo - $movimento->valor;
                //dd($conta->saldo_atual);
            }else{
                //dd($conta->saldo_atual);
                $conta->saldo_atual = $saldo + $movimento->valor;
                //dd($conta->saldo_atual);
            }

            if($movimento->imagem_doc){
                $fotoDelete = $movimento->imagem_doc;
                Storage::delete('docs' . '/' . $fotoDelete);
            }

            $movimento->forceDelete();
            Movimento::destroy($oldId);

            $conta->save();

            return redirect()->route('contas.detalhe', $movimento->conta_id)
            ->with('alert-msg', 'Movimento "'.$movimento->id.'"foi apagado com sucesso')
            ->with('alert-type','success');

        } catch (\Throwable $th) {
            //throw $th;
            if ($th->errorInfo[1]=1451) {
                return redirect()->route('contas.detalhe', $movimento->conta_id)
                ->with('alert-msg', 'Não foi possível apagar o movimento "' . $oldId . '", porque este movimento já está em uso!')
                    ->with('alert-type', 'danger');
            }else{
                return redirect()->route('contas.detalhe', $movimento->conta_id)
                    ->with('alert-msg', 'Não foi possível apagar o movimento "' . $oldId . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    
}
