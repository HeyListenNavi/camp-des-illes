<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camper_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('camper_id')->constrained('campers')->restrictOnDelete();
            $table->string('session_year');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->unique(['camper_id', 'session_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camper_registrations');
    }
};
