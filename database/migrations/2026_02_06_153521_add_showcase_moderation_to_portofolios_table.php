<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portofolios', 'is_showcase')) {
                $table->boolean('is_showcase')->default(false)->after('user_id');
            }

            if (!Schema::hasColumn('portofolios', 'moderation_status')) {
                $table->string('moderation_status', 20)->nullable()->after('is_showcase');
            }

            if (!Schema::hasColumn('portofolios', 'moderation_reason')) {
                $table->text('moderation_reason')->nullable()->after('moderation_status');
            }

            if (!Schema::hasColumn('portofolios', 'moderated_by')) {
                $table->foreignId('moderated_by')->nullable()->after('moderation_reason')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('portofolios', 'moderated_at')) {
                $table->dateTime('moderated_at')->nullable()->after('moderated_by');
            }

            $table->index(['is_showcase', 'moderation_status']);
        });
    }

    public function down(): void
    {
        Schema::table('portofolios', function (Blueprint $table) {
            if (Schema::hasColumn('portofolios', 'moderated_by')) {
                $table->dropConstrainedForeignId('moderated_by');
            }

            if (Schema::hasColumn('portofolios', 'is_showcase')) {
                $table->dropColumn('is_showcase');
            }

            if (Schema::hasColumn('portofolios', 'moderation_status')) {
                $table->dropColumn('moderation_status');
            }

            if (Schema::hasColumn('portofolios', 'moderation_reason')) {
                $table->dropColumn('moderation_reason');
            }

            if (Schema::hasColumn('portofolios', 'moderated_at')) {
                $table->dropColumn('moderated_at');
            }
        });
    }
};
