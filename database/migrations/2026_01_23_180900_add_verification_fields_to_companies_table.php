<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('id');
            }

            if (!Schema::hasColumn('companies', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('is_verified');
            }

            if (!Schema::hasColumn('companies', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('companies', 'verification_note')) {
                $table->string('verification_note', 255)->nullable()->after('verified_by');
            }

            if (!Schema::hasColumn('companies', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('verification_note');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'verified_by')) {
                $table->dropConstrainedForeignId('verified_by');
            }

            if (Schema::hasColumn('companies', 'verified_at')) {
                $table->dropColumn('verified_at');
            }

            if (Schema::hasColumn('companies', 'is_verified')) {
                $table->dropColumn('is_verified');
            }

            if (Schema::hasColumn('companies', 'verification_note')) {
                $table->dropColumn('verification_note');
            }

            if (Schema::hasColumn('companies', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
