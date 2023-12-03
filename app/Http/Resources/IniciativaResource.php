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
            'descricao' => $this->descricao,
            'expectativa' => $this->expectativa,
            'instrumento' => $this->instrumento,
            'setor' => Iniciativa::where('setor', $this->setor)->with('setor')->first(),
            'user' => Iniciativa::where('user', $this->user)->with('user')->first(),
            'usuario_que_alterou' => Iniciativa::where('usuario_que_alterou', $this->usuario_que_alterou)->with('user')->first()  ,
            'status' => Iniciativa::where('status', $this->status)->with('status')->first()
        ];
    }
}
