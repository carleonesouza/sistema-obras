<?php

namespace App\Http\Requests\Empreendimentos;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpreendimentoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => ['required', 'string', 'max:200'],
            'responsavel' => ['required', 'string', 'max:200'],
            'respondente'=> ['required', 'string', 'max:200'],
            'setor'=>['required'],
            'status'=> ['required']          
            
        ];
    }
}
