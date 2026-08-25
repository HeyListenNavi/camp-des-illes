<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camper_medicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_id')->constrained('campers')->cascadeOnDelete();
            $table->text('allergies')->nullable();
            $table->text('medications')->nullable();
            $table->text('dietary_restrictions')->nullable();
            $table->text('critical_alerts')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camper_medicals');
    }
};
