<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ContaPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    
     

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

       

        return [
            'nome'=>['required','string','max:20',Rule::unique('contas')->where(function ($query) {
               
                 return $query->where('user_id',Auth::id());
            }) ],
            
            'descricao'=>'nullable|string',
            'saldo_abertura'=>'required|numeric'
           
        ];
    }

    public function messages(){
        return [
            
            'nome.required'=>'Campo "nome" tem que ser preenchido',
            'nome.lenght' => 'Campo "nome" tem tamanho maximo de 20 carateres',
            'saldo_abertura.required'=> 'Campo "saldo_abertura" tem que ser preenchido',
            'saldo_abertura.numeric'=> 'Campo "saldo_abertura" tem de ser um valor positivo ou negativo'
        ];
    }
}
