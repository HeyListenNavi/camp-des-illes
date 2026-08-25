<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camper_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camper_registration_id')->constrained('camper_registrations')->cascadeOnDelete();
            $table->boolean('photo_permission')->default(false);
            $table->boolean('travel_permission')->default(false);
            $table->boolean('contact_permission')->default(false);
            $table->boolean('medical_permission')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camper_consents');
    }
};
