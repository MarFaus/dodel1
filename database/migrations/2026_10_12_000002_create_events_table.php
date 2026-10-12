<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained('halls')->cascadeOnDelete();
            $table->string('title');
            $table->string('category');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->integer('duration_minutes')->default(120);
            $table->string('age_limit')->default('0+');
            $table->json('prices');
            $table->string('status')->default('active');
            $table->json('bg_gradient')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
    }
};