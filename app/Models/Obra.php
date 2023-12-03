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
        'responsavel',
        'intervencao',
        'instrumento',
        'dataInicio',
        'dataConclusao',
        'documentosAdicionais',
        'arquivoGeorreferenciado',
        'municipios',
        'uf',
        'sim_nao',
        'longitude',
        'latitude',
        'valorGlobal',
        'percentualFinanceiroExecutado',
        'situacao',
        'codigoIATA',
        'tipoAviaoRecICAO',
        'extensao',
        'usuario_que_alterou',
        'novaLargura',
        'user',
        'novaAreaCriada',
        'rodovia',
        'kmInicial',
        'kmFinal',
        'codigo',
        'versao',
        'tipoEmbarcacao',
        'ampliacaoCapacidade',
        'produtos',
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
        'bitola',
        'novaVelocidade',
        'tipoDuto',
        'funcaoEstrutura',
        'materialTransportado',
        'nivelDuto',
        'codigoOrigem',
        'natureza_empreendimento',
        'codigoDestino',
        'data_base_orcamento',
        'nomeXRL', 
        'funcao_estrutura',
        'nivel_duto',
        'tipo_duto',
        'status',
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

    public function UF() {
        return $this->belongsTo(UF::class, 'uf');
    }

    public function produto() {
        return $this->belongsTo(Produto::class, 'produto');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user');
    }

    public function funcao_estrutura() {
        return $this->belongsTo(FuncaoEstrutura::class, 'funcao_estrutura');
    }

    public function intervencao() {
        return $this->belongsTo(Intervencao::class, 'intervencao');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status');
    }

    public function situacao() {
        return $this->belongsTo(Situacao::class, 'situacao');
    }

    public function sim_nao() {
        return $this->belongsTo(SimNao::class, 'sim_nao');
    }

    public function tipo_duto() {
        return $this->belongsTo(TipoDuto::class, 'tipo_duto');
    }

    public function nivel_duto() {
        return $this->belongsTo(NivelDuto::class, 'nivel_duto');
    }

    public function natureza_empreendimento() {
        return $this->belongsTo(NaturezaEmpreendimento::class, 'natureza_empreendimento');
    }

    public function bitola() {
        return $this->belongsTo(Bitola::class, 'bitola');
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'obra_produto');
    }

    public function municipios()
    {
        return $this->belongsToMany(Municipio::class, 'obra_municipios');
    }
}
