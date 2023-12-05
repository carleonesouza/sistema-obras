<?php

namespace App\Http\Requests\Iniciativas;

use Illuminate\Foundation\Http\FormRequest;

class StoreIniciativaRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:500'],
            'responsavel' => ['required', 'string', 'max:200'],
            'descricao'=> ['required', 'string', 'max:800'],
            'expectativa'=> ['required', 'string', 'max:200'],          
            'instrumento' => ['required','string', 'max:200'],
            'setor'=>['required'],
            'user' =>['required'],
            'status'=> ['required']
        ];
    }
}
