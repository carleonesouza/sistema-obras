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
            'respondente' => $this->respondente,
            'setor' => Empreendimento::where('id', '=',$this->setor)->with('setor')->first(),   
            'status' => $this->status,
            'obras' => ObraResource::collection(Obra::where('empreendimento',  $this->id)->with('empreendimento')->get()),
            'user' =>  Empreendimento::where('id', '=',$this->user)->with('user')->first(),    
        ];
    }
}
