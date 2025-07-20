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
        Schema::create('publications', function (Blueprint $table) {
        $table->id();
        $table->string('title_publication');
        $table->string('type_publication');
        $table->string('severity_publication');
        $table->string('location_publication');
        $table->text('description_publication');
        $table->string('url_imagen')->nullable();

        // Clave foranea correcta
        $table->unsignedBigInteger('role_id');
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

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
