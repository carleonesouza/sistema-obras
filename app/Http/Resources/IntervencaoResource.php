<?php

namespace App\Http\Resources;

use App\Models\Intervencao;
use Illuminate\Http\Resources\Json\JsonResource;

class IntervencaoResource extends JsonResource
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
            'setor' => Intervencao::where('setor', $this->setor)->with('setor')->first(),
        ];
    }
}
