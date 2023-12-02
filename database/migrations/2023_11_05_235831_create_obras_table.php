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
            
            $table->string('tipo');
            $table->string('descricao')->nullable()->unique();
            
            $table->foreignId('user')->references('id')->on('users'); 

            $table->foreignId('uf')->references('id')->on('u_f_s');
          
            $table->foreignId('tipo_infraestrutura')->references('id')->on('tipo_infraestruturas');

            $table->foreignId('empreendimento')->references('id')->on('empreendimentos')->unique();
        
            $table->unsignedBigInteger('intervencao')->nullable()->unique();
            $table->foreign('intervencao')->references('id')->on('intervencaos');

            $table->unsignedBigInteger('status')->nullable()->unique();
            $table->foreign('status')->references('id')->on('statuses');

            $table->unsignedBigInteger('situacao')->nullable();
            $table->foreign('situacao')->references('id')->on('situacaos');

            $table->unsignedBigInteger('sim_nao')->nullable();
            $table->foreign('sim_nao')->references('id')->on('sim_naos');

            $table->unsignedBigInteger('tipo_duto')->nullable();
            $table->foreign('tipo_duto')->references('id')->on('tipo_dutos');

            $table->unsignedBigInteger('funcao_estrutura')->nullable();
            $table->foreign('funcao_estrutura')->references('id')->on('funcao_estruturas');

            $table->unsignedBigInteger('nivel_duto')->nullable();
            $table->foreign('nivel_duto')->references('id')->on('nivel_dutos');

            $table->unsignedBigInteger('produto')->nullable();
            $table->foreign('produto')->references('id')->on('produtos');

            $table->unsignedBigInteger('usuario_que_alterou')->nullable();
            $table->foreign('usuario_que_alterou')->references('id')->on('users');

            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('municipio')->nullable();

            $table->date('data_base_orcamento')->nullable();
            $table->string('instrumento')->nullable();
            $table->date('dataInicio');
            $table->date('dataConclusao');
            $table->string('documentosAdicionais')->nullable();
            $table->string('arquivoGeorreferenciado')->nullable();
            $table->float('valorGlobal')->nullable();
            $table->float('percentualFinanceiroExecutado')->nullable();
          
            //Obra Aeroportuária
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
            $table->string('materialTransportado')->nullable();    
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
