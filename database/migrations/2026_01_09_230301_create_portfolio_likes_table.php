<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portofolio_id')->constrained('portofolios')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // yang like
            $table->timestamps();

            $table->unique(['portofolio_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_likes');
    }
};
