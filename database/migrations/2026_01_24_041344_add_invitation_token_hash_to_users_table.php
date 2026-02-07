<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'invitation_token_hash')) {
                $table->string('invitation_token_hash', 64)->nullable()->index()->after('invitation_token');
            }
            if (Schema::hasColumn('users', 'invitation_token')) {
                $table->string('invitation_token')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'invitation_token_hash')) {
                $table->dropColumn('invitation_token_hash');
            }
        });
    }
};
