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
        Schema::create('obra_municipios', function (Blueprint $table) {
            $table->unsignedBigInteger('obra_id');
            $table->unsignedBigInteger('municipio_id');
            $table->primary(['obra_id', 'municipio_id']); // Composite primary key
        
            // Foreign key constraints
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
        
            $table->timestamps();
        });

        // Schema::table('obra_municipio', function(Blueprint $table) {
        //     $table->renameColumn('obra', 'obra_id');
        //     $table->renameColumn('municipio_id', 'municipio');
        // });

        //Schema::rename('obra_municipios', 'obra_municipio');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obra_municipios');
    }
};
