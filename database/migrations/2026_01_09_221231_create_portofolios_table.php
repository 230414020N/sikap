<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable(); // misal: Web, Mobile, Design, Data, dll
            $table->string('tools')->nullable();    // misal: Laravel, Figma, Python
            $table->string('link_demo')->nullable();
            $table->string('link_github')->nullable();

            $table->string('thumbnail_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolios');
    }
};
