<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'invitation_token')) {
                $table->string('invitation_token', 80)->nullable()->unique()->after('remember_token');
            }

            if (!Schema::hasColumn('users', 'invited_at')) {
                $table->timestamp('invited_at')->nullable()->after('invitation_token');
            }

            if (!Schema::hasColumn('users', 'password_set_at')) {
                $table->timestamp('password_set_at')->nullable()->after('invited_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'invitation_token')) {
                $table->dropUnique(['invitation_token']);
                $table->dropColumn('invitation_token');
            }

            if (Schema::hasColumn('users', 'invited_at')) {
                $table->dropColumn('invited_at');
            }

            if (Schema::hasColumn('users', 'password_set_at')) {
                $table->dropColumn('password_set_at');
            }
        });
    }
};
