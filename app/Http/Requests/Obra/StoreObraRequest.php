<?php

namespace App\Http\Requests\Obra;

use Illuminate\Foundation\Http\FormRequest;

class StoreObraRequest extends FormRequest
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
            'descricao' => ['required', 'string', 'max:200'],
            'tipo' => ['required'],
            'responsavel' => ['required'],
            'empreendimento' => ['required'],
            'tipo_infraestrutura' => ['required'],
            'intervencao' => ['required'],
            'dataInicio' => ['required'],
            'dataConclusao' => ['required'],
            'status' => ['required'],
            'user' => ['required'],
            'data_base_orcamento' => ['required'],
            'instrumento' => ['required'],
        ];
    }
}
