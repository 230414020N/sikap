<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portofolios', 'is_public')) {
                $table->boolean('is_public')->default(true)->after('thumbnail_path');
            }

            if (!Schema::hasColumn('portofolios', 'is_taken_down')) {
                $table->boolean('is_taken_down')->default(false)->after('is_public');
            }

            if (!Schema::hasColumn('portofolios', 'taken_down_reason')) {
                $table->string('taken_down_reason', 255)->nullable()->after('is_taken_down');
            }

            if (!Schema::hasColumn('portofolios', 'taken_down_at')) {
                $table->timestamp('taken_down_at')->nullable()->after('taken_down_reason');
            }

            if (!Schema::hasColumn('portofolios', 'taken_down_by')) {
                $table->foreignId('taken_down_by')->nullable()->after('taken_down_at')->constrained('users')->nullOnDelete();
            }

            $table->index(['is_public', 'is_taken_down']);
        });
    }

    public function down(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            if (Schema::hasColumn('portofolios', 'taken_down_by')) {
                $table->dropConstrainedForeignId('taken_down_by');
            }

            if (Schema::hasColumn('portofolios', 'taken_down_at')) {
                $table->dropColumn('taken_down_at');
            }

            if (Schema::hasColumn('portofolios', 'taken_down_reason')) {
                $table->dropColumn('taken_down_reason');
            }

            if (Schema::hasColumn('portofolios', 'is_taken_down')) {
                $table->dropColumn('is_taken_down');
            }

            if (Schema::hasColumn('portofolios', 'is_public')) {
                $table->dropColumn('is_public');
            }
        });
    }
};
