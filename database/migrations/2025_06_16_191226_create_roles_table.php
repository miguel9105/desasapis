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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name'); // Nombre del rol
            $table->string('administrators'); // Cambiado a string
            $table->string('community'); // Cambiado a string
            $table->string('zone_community'); // Cambiado a string
            $table->string('mail_administrator'); // Cambiado a string (sería mejor email si es un correo)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
