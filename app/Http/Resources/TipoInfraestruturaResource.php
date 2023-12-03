<?php

namespace App\Http\Resources;

use App\Models\TipoInfraestrutura;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoInfraestruturaResource extends JsonResource
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
            'id' => (string) $this->id,
            'descricao' => $this->descricao,
            'setor' => TipoInfraestrutura::where('setor', $this->setor)->with('setor')->first(),
        ];
    }
}
