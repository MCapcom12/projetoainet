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

        //dd($conta->movimentos()->get('data'));
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
        $movimento = Movimento::create($validated_data);
        $this->calcularSaldos($conta, $movimento);
        $conta->save();
        //$this->calcularSaldos($movimento->contas, $movimento);
        

        return redirect()->route('contas.detalhe' ,['conta'=>$conta])
            ->with('alert-msg','Movimento criada com sucesso')
           ->with('alert-type','success');
    }


    public function edit(Movimento $movimento){
        //dd($movimento->id);
        $categorias=Categoria::all();
        return view('movimentos.edit')->withCategorias($categorias)                                 
                                      ->withMovimento($movimento);
    }


    public function update(MovimentoPost $request, Movimento $movimento){
        //dd($movimento);
        $validated_data =$request -> validated();
        //$validated_data["conta_id"]=$movimento->id;
        //dd($movimento->saldo_final);
        $validated_data['saldo_inicial']=$movimento->saldo_inicial;
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
        //$this->calcularSaldos($movimento->contas, $movimento);
        $movimento->save();
        $this->calcularSaldos($movimento->contas, $movimento);

        
        return redirect()->route('contas.detalhe', $movimento->conta_id)
           
            ->with('alert-msg', 'Movimento foi alterado com sucesso!')
            ->with('alert-type','success');
    }
    
    
    private function calcularSaldos(Conta $conta, Movimento $movimento){
        //$ultimoMovimentoValido=Movimento::where conta_id = x , data < $movimento->data 
        $ultimoMovimentoValidoDatasDiferentes=Movimento::where('conta_id', '=', $conta->id)
                                          ->where('data', '<', $movimento->data);
                                          //->get();
                                          //->where('id','<', $movimento->id)
                                          //->orderBy('data','desc')
                                          //->orderBy('id','desc');

        $ultimoMovimentoValidoDatasIguais=Movimento::where('conta_id', '=', $conta->id)
                                                    ->where('data', '=', $movimento->data)
                                                    ->where('id','<', $movimento->id);
                                                    //->get();
                                                    //->orderBy('data','desc')
                                                    //->orderBy('id','desc');

        $resultado=$ultimoMovimentoValidoDatasDiferentes->union($ultimoMovimentoValidoDatasIguais);
        $resultado->orderBy('data','desc')
                  ->orderBy('id','desc');
        
        $ultimoMovimentoValido=$resultado->first();
        //dd($ultimoMovimentoValido);
        
                  //dd($ultimoMovimentoValido);
        //dd($ultimoMovimentoValido->saldo_final);
        if($ultimoMovimentoValido){
            $movimento->saldo_inicial=$ultimoMovimentoValido->saldo_final;
            //dd($movimento->saldo_inicial);
            if($movimento->tipo == 'D'){
                $movimento->saldo_final = $movimento->saldo_inicial - $movimento->valor;
            }else{
                $movimento->saldo_final = $movimento->saldo_inicial + $movimento->valor;
            }

            
            $movimento->save();
            //$conta->saldo_atual=$movimento->saldo_final;

        }   
        //dd($movimento);
        //dd($movimento->saldo_final);
        //$conta->first();
        //$ultimoMovimentoValido->first();        
        //Order By data, desc
        //Order by id, desc 
        //->First() -> valor inicial da conta, caso seja null vou buscar à conta
     
        $movimentosParaAlterarDatasDiferentes = Movimento::where('conta_id', '=', $conta->id)
                                            ->where('data', '>', $movimento->data);
                                            //->where('id','>', $movimento->id)
                                            //->orderBy('data','asc')
                                            //->orderBy('id','asc')
                                            //->get();

        $movimentosParaAlterarDatasIguais = Movimento::where('conta_id', '=', $conta->id)
                                            ->where('data', '=', $movimento->data)
                                            ->where('id','>', $movimento->id);
                                            //->orderBy('data','asc')
                                            //->orderBy('id','asc')
                                            //->get();

        $resultadoParaAlterar=$movimentosParaAlterarDatasDiferentes->union($movimentosParaAlterarDatasIguais);
        $resultadoParaAlterar->orderBy('data','asc')
                    ->orderBy('id','asc');
        
        $movimentosParaAlterar=$resultadoParaAlterar->get();
        
        //dd($movimentosParaAlterar);


        for ($i=0; $i < sizeof($movimentosParaAlterar); $i++) { 
            # code...
            $mov=$movimentosParaAlterar[$i];
            //dd($mov);
            if($i==0){
                $mov->saldo_inicial=$movimento->saldo_final;
                //dd($mov->saldo_inicial);
                if($mov->tipo == 'D'){
                    $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                    
                }else{
                    $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                }

            }else{
                $mov->saldo_inicial=$movimentosParaAlterar[$i-1]->saldo_final;
                //dd($mov->saldo_inicial); 
                if($mov->tipo == 'D'){
                    $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                }else{
                    $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                } 

            }
            
            $conta->saldo_atual=$mov->saldo_final;
            $conta->save();

            $mov->save();
        }
        
        

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
        $movimentoAnterior = $this->getLastMovimento($movimento, $movimento->contas); 
        // if(!$movimentoAnterior){
        //     $movimentoASeguir = $this->getNextMovimento($movimento, $movimento->contas);
        //     //buscar o a seguir
        //     //alterar o a seguir->saldo_inicial para igual ao que vou apagar -> saldo _inicial
        // }
        
        
        try {
            //$conta=$movimento->contas->where('conta_id', $movimento->id);
            
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

            $this->calcularSaldosOnDelete($movimentoAnterior, $movimentoAnterior->contas);
            

            return redirect()->back()
            ->with('alert-msg', 'Movimento "'.$movimento->id.'"foi apagado com sucesso')
            ->with('alert-type','success');

        } catch (\Throwable $th) {
            //throw $th;
            if ($th->errorInfo[1]=1451) {
                return redirect()->back()//route('contas.detalhe', $movimento->conta_id)
                ->with('alert-msg', 'Não foi possível apagar o movimento "' . $oldId . '", porque este movimento já está em uso!')
                    ->with('alert-type', 'danger');
            }else{
                return redirect()->back()//route('contas.detalhe', $movimento->conta_id)
                    ->with('alert-msg', 'Não foi possível apagar o movimento "' . $oldId . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

    
    private function getLastMovimento(Movimento $movimento, Conta $conta){
        $ultimoMovimentoValidoDatasDiferentes=Movimento::where('conta_id', '=', $conta->id)
                                          ->where('data', '<', $movimento->data);
                                          //->get();
                                          //->where('id','<', $movimento->id)
                                          //->orderBy('data','desc')
                                          //->orderBy('id','desc');

        $ultimoMovimentoValidoDatasIguais=Movimento::where('conta_id', '=', $conta->id)
                                                    ->where('data', '=', $movimento->data)
                                                    ->where('id','<', $movimento->id);
                                                    //->get();
                                                    //->orderBy('data','desc')
                                                    //->orderBy('id','desc');

        $resultado=$ultimoMovimentoValidoDatasDiferentes->union($ultimoMovimentoValidoDatasIguais);
        $resultado->orderBy('data','desc')
                  ->orderBy('id','desc');
        $resultadoFinal=$resultado->first();

        return $resultadoFinal;     
    }

    private function getNextMovimento(Movimento $movimento, Conta $conta){
        $movimentosParaAlterarDatasDiferentes = Movimento::where('conta_id', '=', $conta->id)
                                            ->where('data', '>', $movimento->data);
                                            //->where('id','>', $movimento->id)
                                            //->orderBy('data','asc')
                                            //->orderBy('id','asc')
                                            //->get();

        $movimentosParaAlterarDatasIguais = Movimento::where('conta_id', '=', $conta->id)
                                            ->where('data', '=', $movimento->data)
                                            ->where('id','>', $movimento->id);
                                            //->orderBy('data','asc')
                                            //->orderBy('id','asc')
                                            //->get();

        $resultadoParaAlterar=$movimentosParaAlterarDatasDiferentes->union($movimentosParaAlterarDatasIguais);
        $resultadoParaAlterar->orderBy('data','asc')
                    ->orderBy('id','asc');
        
        $movimentosParaAlterar=$resultadoParaAlterar->first();

        return $movimentosParaAlterar;
    }

    private function calcularSaldosOnDelete(Movimento $movimento, Conta $conta){
        
        //$movimento=getLastMovimento($movimento);
     
        $movimentosParaAlterarDatasDiferentes = Movimento::where('conta_id', '=', $conta->id)
                                            ->where('data', '>', $movimento->data);
                                            //->where('id','>', $movimento->id)
                                            //->orderBy('data','asc')
                                            //->orderBy('id','asc')
                                            //->get();

        $movimentosParaAlterarDatasIguais = Movimento::where('conta_id', '=', $conta->id)
                                            ->where('data', '=', $movimento->data)
                                            ->where('id','>', $movimento->id);
                                            //->orderBy('data','asc')
                                            //->orderBy('id','asc')
                                            //->get();

        $resultadoParaAlterar=$movimentosParaAlterarDatasDiferentes->union($movimentosParaAlterarDatasIguais);
        $resultadoParaAlterar->orderBy('data','asc')
                    ->orderBy('id','asc');
        
        $movimentosParaAlterar=$resultadoParaAlterar->get();
        

        //dd($movimentosParaAlterar);
        if(sizeof($movimentosParaAlterar)==0){
            $conta->saldo_atual=$movimento->saldo_final;
            $conta->save();
        }

        for ($i=0; $i < sizeof($movimentosParaAlterar); $i++) { 
            # code...
            $mov=$movimentosParaAlterar[$i];
            //dd($mov);
            if($i==0){
                $mov->saldo_inicial=$movimento->saldo_final;
                //dd($mov->saldo_inicial);
                if($mov->tipo == 'D'){
                    $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                    
                }else{
                    $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                }

            }else{
                $mov->saldo_inicial=$movimentosParaAlterar[$i-1]->saldo_final;
                //dd($mov->saldo_inicial); 
                if($mov->tipo == 'D'){
                    $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                }else{
                    $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                } 

            }
            
            $conta->saldo_atual=$mov->saldo_final;
            $conta->save();

            $mov->save();
        }
    
    }   

}
