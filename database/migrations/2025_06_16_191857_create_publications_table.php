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
        // crea la tabla publications en la base de datos
        Schema::create('publications', function (Blueprint $table) {
        // crea una columna para cada atributo de la tabla
        $table->id();
        
        $table->string('title');
        $table->string('type');
        $table->string('severity');
        $table->string('location');
        $table->text('description');
        $table->string('image')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
