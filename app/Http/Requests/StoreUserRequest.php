<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'max:50'],
            'instituicao_setor'=> ['required', 'string', 'max:200'],
            'telefone'=> ['required', 'string', 'max:20'],
            'tipo_usuario_id'=> ['required'],
            'senha' => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }
}
