<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('jobs', 'employment_status_id')) {
                $table->foreignId('employment_status_id')
                    ->nullable()
                    ->constrained('employment_statuses')
                    ->nullOnDelete()
                    ->after('deskripsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (Schema::hasColumn('jobs', 'employment_status_id')) {
                $table->dropConstrainedForeignId('employment_status_id');
            }
        });
    }
};
