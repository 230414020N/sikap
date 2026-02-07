<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('jobs', 'job_category_id')) {
                $table->foreignId('job_category_id')->nullable()->after('kategori')->constrained('job_categories')->nullOnDelete();
            }

            if (!Schema::hasColumn('jobs', 'job_location_id')) {
                $table->foreignId('job_location_id')->nullable()->after('lokasi')->constrained('job_locations')->nullOnDelete();
            }

            if (!Schema::hasColumn('jobs', 'education_level_id')) {
                $table->foreignId('education_level_id')->nullable()->after('level')->constrained('education_levels')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (Schema::hasColumn('jobs', 'education_level_id')) {
                $table->dropConstrainedForeignId('education_level_id');
            }

            if (Schema::hasColumn('jobs', 'job_location_id')) {
                $table->dropConstrainedForeignId('job_location_id');
            }

            if (Schema::hasColumn('jobs', 'job_category_id')) {
                $table->dropConstrainedForeignId('job_category_id');
            }
        });
    }
};
