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
            $table->unsignedBigInteger('obra');
            $table->unsignedBigInteger('municipio');
            $table->primary(['obra', 'municipio']); // Composite primary key
        
            // Foreign key constraints
            $table->foreign('obra')->references('id')->on('obras')->onDelete('cascade');
            $table->foreign('municipio')->references('id')->on('municipios')->onDelete('cascade');
        
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
        Schema::dropIfExists('obra_municipios');
    }
};
