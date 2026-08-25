<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->text('address')->nullable();
            $table->text('custody_details')->nullable();
            $table->string('health_card_number')->nullable();
            $table->string('access_token')->unique()->nullable();
            $table->timestamp('access_token_expires_at')->nullable();
            $table->timestamps();

            $table->unique(['first_name', 'last_name', 'date_of_birth']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campers');
    }
};
