<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('opportunity_id')->constrained('opportunities')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('details');
            $table->date('date');
            $table->enum('status', ['call', 'email', 'meeting']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
