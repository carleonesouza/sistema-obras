<?php

namespace App\Http\Resources;

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
            'setor' => SetorResource::where('setor', $this->setor)->with('setor')->first(),      
            'obras' => ObraResource::collection($this->whenLoaded('obras')),
        ];
    }
}
