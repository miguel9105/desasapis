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
        // Crea la tabla 'users' para almacenar la información de los usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Llave primaria autoincremental
            $table->string('name'); // Nombre del usuario
            $table->string('lastname'); // apellido del usuario
            $table->string('email')->unique(); // Correo electrónico único
            $table->string('location'); // ubicacion del usuario}
            
            $table->timestamp('email_verified_at')->nullable(); // Fecha de verificación del correo
            $table->string('password'); // Contraseña del usuario
            $table->rememberToken(); // Token para mantener la sesión iniciada
            $table->timestamps(); // Campos 'created_at' y 'updated_at'
        });

        // Crea la tabla para almacenar tokens de restablecimiento de contraseña
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email como clave primaria
            $table->string('token'); // Token de restablecimiento
            $table->timestamp('created_at')->nullable(); // Fecha de creación del token
        });

        // Crea la tabla para almacenar las sesiones de los usuarios
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de la sesión como clave primaria
            $table->foreignId('user_id')->nullable()->index(); // ID del usuario asociado (puede ser nulo)
            $table->string('ip_address', 45)->nullable(); // Dirección IP del usuario
            $table->text('user_agent')->nullable(); // Información del navegador o dispositivo
            $table->longText('payload'); // Información serializada de la sesión
            $table->integer('last_activity')->index(); // Última actividad (timestamp)
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina las tablas si existen (en orden inverso)
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
