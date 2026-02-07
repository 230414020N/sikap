<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('recommendation', 20)->nullable();

            $table->text('summary')->nullable();

            $table->json('strengths')->nullable();
            $table->json('concerns')->nullable();
            $table->json('questions')->nullable();
            $table->json('next_steps')->nullable();

            $table->string('stage', 50)->nullable();
            $table->dateTime('follow_up_at')->nullable();

            $table->timestamps();

            $table->index(['application_id', 'created_by']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_notes');
    }
};
