<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camper_guardian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_id')->constrained('campers')->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained('guardians')->restrictOnDelete();
            $table->enum('relationship_type', [
                'father',
                'mother',
                'stepfather',
                'stepmother',
                'legal_guardian',
                'emergency_contact',
                'other'
            ]);
            $table->boolean('is_primary_guardian')->default(false);
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camper_guardian');
    }
};
