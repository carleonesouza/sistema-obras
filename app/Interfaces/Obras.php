<?php

namespace App\Interfaces;

interface Obras {
    public function setRespondente($respondente);
    public function setEmpreendimentoVinculado($empreendimento);
    public function setDescricao($descricao);
    public function setTipoInfraestrutura($tipo);
    public function setNomeInfraestrutura($nome);
    public function setIntervencao($intervencao);
    public function setStatus($status);
    public function setSituacaoAeroporto($situacao); // Opcional, dependendo do tipo de obra
    public function setInstrumento($instrumento);
    public function setDataInicio(\DateTime $dataInicio);
    public function setDataConclusao(\DateTime $dataConclusao);
    public function attachDocumentosAdicionais($documentos);
    public function setEndereco(\App\Models\Endereco $endereco);
    public function setArquivoGeorreferenciado($arquivo);
    public function setValorGlobal($valor);
    public function setPercentualFinanceiroExecutado($percentual);
   
}
