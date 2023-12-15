<?php

namespace App\Http\Resources;

use App\Models\Empreendimento;
use App\Models\Obra;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpreendimentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'nome' => $this->nome,
            'responsavel' => $this->responsavel,
            'setor' => Empreendimento::where('setor', $this->setor)->with('setor')->first(),  
            'natureza_empreendimento' => Empreendimento::where('natureza_empreendimento', '=',$this->natureza_empreendimento)->with('natureza_empreendimento')->first(),   
            'obras' => ObraResource::collection(Obra::where('empreendimento',  $this->id)->with('empreendimento')->get()),
            'user' =>  Empreendimento::where('user',$this->user)->with('user')->first(),    
            'status' => $this->status,
        ];
    }
}
