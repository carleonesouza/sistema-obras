<?php

namespace App\Http\Resources;

use App\Models\Obra;
use App\Models\SimNao;
use App\Models\Situacao;
use App\Models\UF;
use Illuminate\Http\Resources\Json\JsonResource;

class ObraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $baseArray = [
            'id' => (string)$this->id,
            'tipo' => $this->tipo,
            'descricao' => $this->descricao,
            'responsavel' => $this->responsavel,
            'latitude' => $this->latitude,
            'user' =>  Obra::where('user', $this->user)->with('user')->first(),
            'longitude' => $this->longitude,
            'instrumento' => $this->instrumento,
            'municipios' => MunicipioResource::collection($this->whenLoaded('municipios')),
            'dataInicio' => $this->dataInicio,
            'dataConclusao' => $this->dataConclusao,
            'data_base_orcamento' => $this->data_base_orcamento,
            'documentosAdicionais' => $this->documentosAdicionais,
            'arquivoGeorreferenciado' => $this->arquivoGeorreferenciado,
            'valorGlobal' => $this->valorGlobal,
            'percentualFinanceiroExecutado' => $this->percentualFinanceiroExecutado,
            'codigoIATA' => $this->codigoIATA,
            'tipoAviaoRecICAO' => $this->tipoAviaoRecICAO,
            'extensao' => $this->extensao,
            'novaLargura' => $this->novaLargura,
            'novaAreaCriada' => $this->novaAreaCriada,
            'codigoOrigem' => $this->codigoOrigem,
            'codigoDestino' => $this->codigoDestino,
            'nomeXRL' => $this->nomeXRL,
            'extensao' => $this->extensao,
            'espessura' => $this->espessura,
            'vazaoProjeto' => $this->vazaoProjeto,
            'vazaoOperacional' => $this->vazaoOperacional,
            'novaAreaImpactada' => $this->novaAreaImpactada,            
            'tipoEmbarcacao' => $this->tipoEmbarcacao,
            'profundidadeMinima' => $this->profundidadeMinima,
            'profundidadeMaxima' => $this->profundidadeMaxima,
            'comboiosCheia' => $this->comboiosCheia,
            'comboiosEstiagem' => $this->comboiosEstiagem,
            'novoComprimento' => $this->novoComprimento,
            'rodovia' => $this->rodovia,
            'kmInicial' => $this->kmInicial,
            'kmFinal' => $this->kmFinal,
            'codigo' => $this->codigo,
            'versao' => $this->versao,
            'novoCalado' => $this->novoCalado,
            'capacidadeDinamica' => $this->capacidadeDinamica,
            'materialTransportado' => $this->materialTransportado,
            'novaVelocidade' => $this->novaVelocidade,
            'status' =>  Obra::where('status', $this->status)->with('status')->first(),
            'produtos' => ProdutoResource::collection($this->whenLoaded('produtos')),
            'tipo_infraestrutura' =>  Obra::where('tipo_infraestrutura', $this->tipo_infraestrutura)->with('tipo_infraestrutura')->first(),
            'intervencao' => Obra::where('intervencao', $this->intervencao)->with('intervencao')->first(),
            'empreendimento' => Obra::where('empreendimento', $this->empreendimento)->with('empreendimento')->first(),
          
        ];
        $obra = Obra::with(['uf', 'tipo_duto', 'funcao_estrutura','nivel_duto',  'bitola'])->find($this->id);
        $atributoUf = $obra->uf ? $obra->uf : null;
        $tipoDuto = $obra->tipo_duto ? $obra->tipo_duto : null;
        $tipoEstrutura = $obra->funcao_estrutura ? $obra->funcao_estrutura : null;
        $nivel_duto = $obra->nivel_duto ? $obra->nivel_duto : null;
        $bitola =  $obra->bitola ? $obra->bitola : null;
        
        $uf = $atributoUf ? ['uf' => Obra::where('uf', $this->uf)->with('uf')->first()] : [];

        $hidroviaria = $this->tipo === 'Hidroviário' ? [
            'ampliacaoCapacidade' => SimNao::where('id', (int) $this->ampliacaoCapacidade)->first(),
            'temEclusa' => SimNao::where('id', (int) $this->temEclusa)->first(),
            'temBarragem' => SimNao::where('id', (int) $this->temBarragem)->first(),
            'situacaoHidrovia' => Situacao::where('id', (int) $this->situacaoHidrovia)->first(),

        ] : [];

        $ferroviaria = $this->tipo === 'Ferroviário' ? [
            'bitola' => $bitola ? Obra::where('bitola', $this->bitola)->with('bitola')->first() : null,
        ] : [];

        $portuaria = $this->tipo === 'Portuário' ? [
            'ampliacaoCapacidade' => SimNao::where('id', (int) $this->ampliacaoCapacidade)->first(),
        ] : [];

        $conditionalArray = $this->tipo === 'Dutoviário' ? [
                'tipo_duto' => $tipoDuto ? Obra::where('tipo_duto', $this->tipo_duto)->with('tipo_duto')->first() : null,
                'funcao_estrutura' => $tipoEstrutura ? Obra::where('funcao_estrutura', $this->funcao_estrutura)->with('funcao_estrutura')->first() : null,
                'nivel_duto' =>  $nivel_duto ? Obra::where('nivel_duto', $this->nivel_duto)->with('nivel_duto')->first() : null,
            ] : [];

        return $baseArray + $conditionalArray + $hidroviaria  + $portuaria + $ferroviaria + $uf;
    }
}
