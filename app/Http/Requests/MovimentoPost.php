<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MovimentoPost extends FormRequest
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
            'data' => 'required|date_format:Y/m/d',
            'valor' => 'required|integer|gt:0',
            'tipo' => 'required|string|in:D,R',
            'categoria_id' => 'nullable',
            'descricao'=>'nullable|string'
        ];
    }

    public function messages(){
        return [
            
            'data.required'=>'Campo "data" tem que ser preenchido',
            'valor.required'=> 'Campo "valor" tem que ser preenchido',
            'valor.integer'=> 'Campo "valor" tem que ser maior que 0'
        ];
    }
}
