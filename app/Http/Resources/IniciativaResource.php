<?php

namespace App\Http\Resources;

use App\Models\Iniciativa;
use Illuminate\Http\Resources\Json\JsonResource;

class IniciativaResource extends JsonResource
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
            'nome' => $this->nome,
            'responsavel' => $this->responsavel,
            'ele_principal_afetado' => $this->ele_principal_afetado,
            'expectativa' => $this->expectativa,
            'instrumento' => $this->instrumento,
            'setor' => Iniciativa::where('setor', $this->setor)->with('setor')->first(),
            'usuario' => Iniciativa::where('usuario', $this->usuario)->with('usuario')->first(),
            'usuario_alteracao' => $this->usuario_alteracao,
            'status' => $this->status
        ];
    }
}
