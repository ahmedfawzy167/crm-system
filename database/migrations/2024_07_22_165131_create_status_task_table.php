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
        Schema::create('status_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('statuses')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_task');
    }
};
