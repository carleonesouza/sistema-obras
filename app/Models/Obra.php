<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;

    protected $fillable = [
        'empreendimento',
        'tipo',
        'tipo_infraestrutura',
        'descricao',
        'intervencao',
        'instrumento',
        'dataInicio',
        'dataConclusao',
        'documentosAdicionais',
        'arquivoGeorreferenciado',
        'endereco',
        'valorGlobal',
        'percentualFinanceiroExecutado',
        'situacaoAeroporto',
        'codigoIATA',
        'tipoAviaoRecICAO',
        'extensao',
        'novaLargura',
        'novaAreaCriada',
        'rodovia',
        'kmInicial',
        'kmFinal',
        'codigo',
        'versao',
        'tipoEmbarcacao',
        'ampliacaoCapacidade',
        'produto',
        'novoCalado',
        'novoComprimento', 
        'capacidadeDinamica',
        'situacaoHidrovia',
        'temEclusa',
        'temBarragem',
        'profundidadeMinima',
        'profundidadeMaxima',
        'comboiosCheia',
        'comboiosEstiagem',
        'novaBitola',
        'novaVelocidade',
        'tipoDuto',
        'funcaoEstrutura',
        'materialTransportado',
        'nivelDuto',
        'codigoOrigem',
        'codigoDestino',
        'nomeXRL', 
        'espessura',
        'vazaoProjeto',
        'vazaoOperacional',
        'novaAreaImpactada',
    ];


    public function empreendimento() {
        return $this->belongsTo(Empreendimento::class, 'empreendimento');
    }
    
    public function tipo_infraestrutura() {
        return $this->belongsTo(TipoInfraestrutura::class, 'tipo_infraestrutura');
    }

    public function endereco() {
        return $this->belongsTo(Endereco::class, 'endereco');
    }

    public function produto() {
        return $this->belongsTo(Produto::class, 'produto');
    }
}
