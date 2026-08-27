<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_events', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->foreignId('guest_group_id')->constrained('guest_groups')->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('expected_attendees');
            $table->string('status')->default('inquiry_received');
            $table->text('operational_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_events');
    }
};
