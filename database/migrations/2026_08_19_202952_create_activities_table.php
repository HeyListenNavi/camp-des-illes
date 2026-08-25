<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej. "Tirolesa Nocturna", "Senderismo Guiado"
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->nullable(); // Duración en minutos
            $table->decimal('price_per_person', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};