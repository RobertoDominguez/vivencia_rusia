<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Transaccion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->float('monto');
            $table->char('es_entrada');
            $table->char('es_servicio');
            $table->integer('duracion')->nullable();

            $table->unsignedBigInteger('id_tipo');
            $table->foreign('id_tipo')->references('id')->on('Tipo')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccions');
    }
};
