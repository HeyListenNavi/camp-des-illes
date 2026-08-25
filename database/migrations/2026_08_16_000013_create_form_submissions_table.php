<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->enum('form_type', ['registration', 'medical', 'consent']);
            $table->foreignId('camper_registration_id')->nullable()->constrained('camper_registrations')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
