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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->boolean('is_admin_message')->default(false);
            $table->boolean('is_read')->default(false);
             // Relación con la tabla 'roles'
            // Si se elimina el rol, también se eliminan sus mensajes
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('cascade'); // Relación con roles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
