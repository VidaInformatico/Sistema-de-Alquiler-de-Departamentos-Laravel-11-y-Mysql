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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->decimal('rentalprice', 10, 2);
            $table->decimal('lightprice', 10, 2);
            $table->decimal('waterprice', 10, 2);
            $table->integer('number');
            // Definir las columnas antes de aplicar las claves foráneas
            $table->unsignedBigInteger('property_id'); // Agregar la columna property_id
            $table->unsignedBigInteger('type_id'); // Agregar la columna type_id
            // Definir las claves foráneas
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
