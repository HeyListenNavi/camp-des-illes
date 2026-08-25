<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_options', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej. "Desayuno Continental", "Almuerzo Ejecutivo"
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack', 'buffet', 'other'])->default('other');
            $table->text('description')->nullable();
            $table->decimal('price_per_person', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_options');
    }
};