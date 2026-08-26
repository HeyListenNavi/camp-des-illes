<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: "Campamento de Verano", "Campamento de Invierno"
            $table->string('year', 4); // Ej: "2026"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tablas pivote para agrupar Campers y Guardians por Sesión/Campamento
        Schema::create('camper_registration_session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_session_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('guardian_registration_session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_session_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardian_registration_session');
        Schema::dropIfExists('camper_registration_session');
        Schema::dropIfExists('registration_sessions');
    }
};