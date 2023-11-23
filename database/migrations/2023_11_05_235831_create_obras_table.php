<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empreendimento')->references('id')->on('empreendimentos');
            $table->string('tipo');
            $table->foreignId('tipo_infraestrutura')->references('id')->on('tipo_infraestruturas');
            $table->string('descricao')->nullable();
            $table->string('intervencao')->nullable();
            $table->boolean('status')->default(true);
            $table->string('instrumento')->nullable();
            $table->string('respondente')->nullable();
            $table->date('dataInicio');
            $table->date('dataConclusao');
            $table->string('documentosAdicionais')->nullable();
            $table->string('arquivoGeorreferenciado')->nullable();
            $table->float('valorGlobal')->nullable();
            $table->float('percentualFinanceiroExecutado')->nullable();
            $table->foreignId('endereco')->references('id')->on('enderecos');
            //Obra Aeroportuária
            $table->string('situacaoAeroporto')->nullable();
            $table->string('codigoIATA')->nullable();
            $table->string('tipoAviaoRecICAO')->nullable();
            $table->float('extensao')->nullable();
            $table->float('novaLargura')->nullable();
            $table->float('novaAreaCriada')->nullable();
            //Obra Rodoviária            
            $table->string('rodovia')->nullable();
            $table->float('kmInicial')->nullable();
            $table->float('kmFinal')->nullable();
            $table->integer('codigo')->nullable();
            $table->integer('versao')->nullable();
            //Obra Portuária
            $table->string('tipoEmbarcacao')->nullable();  
            $table->string('ampliacaoCapacidade')->nullable();  
            $table->foreignId('produto')->references('id')->on('produtos')->nullable();
            $table->float('novoCalado')->nullable();    
            $table->float('capacidadeDinamica')->nullable();
            //Obra Hidroviária
            $table->string('situacaoHidrovia')->nullable();    
            $table->string('temEclusa')->nullable();    
            $table->string('temBarragem')->nullable();        
            $table->float('profundidadeMinima')->nullable();    
            $table->float('profundidadeMaxima')->nullable();    
            $table->string('comboiosCheia')->nullable();    
            $table->string('comboiosEstiagem')->nullable();     
            $table->float('novoComprimento')->nullable();    
            //Obra Ferroviária
            $table->float('novaBitola')->nullable();
            $table->float('novaVelocidade')->nullable();
            //Obra Dutoviária
            $table->string('tipoDuto')->nullable();   
            $table->string('funcaoEstrutura')->nullable();   
            $table->string('materialTransportado')->nullable();   
            $table->string('nivelDuto')->nullable();   
            $table->string('codigoOrigem')->nullable();   
            $table->string('codigoDestino')->nullable();   
            $table->string('nomeXRL')->nullable();   
            $table->float('espessura')->nullable();   
            $table->float('vazaoProjeto')->nullable();   
            $table->float('vazaoOperacional')->nullable();   
            $table->float('novaAreaImpactada')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obras');
    }
};
