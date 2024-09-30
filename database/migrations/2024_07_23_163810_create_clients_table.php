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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); //Nombre completo
            $table->date('date_of_birth'); //Fecha naciemiento
            $table->string('gender')->nullable(); //Genero
            $table->string('phone')->nullable(); //Telefono
            $table->string('email')->unique()->nullable(); //Correo
            $table->string('address')->nullable(); //Dirección
            $table->string('city')->nullable(); // Ciudad
            $table->string('state')->nullable(); //Estado
            $table->string('postal_code')->nullable(); //Codigo Postal
            $table->string('country')->nullable(); // Pais
            $table->string('identification_number')->nullable(); //Numero de Identidad
            $table->string('identification_type')->nullable(); //Tipo de Identidad
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
