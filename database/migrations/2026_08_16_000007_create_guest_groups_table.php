<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_groups', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('name');
            $table->string('organization_name')->nullable();
            $table->string('primary_contact_name');
            $table->string('phone');
            $table->string('email');
            $table->text('address')->nullable();
            $table->text('internal_notes')->nullable();
            $table->string('access_token')->unique()->nullable();
            $table->timestamp('access_token_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_groups');
    }
};
