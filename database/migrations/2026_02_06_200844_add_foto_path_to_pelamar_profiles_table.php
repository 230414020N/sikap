<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pelamar_profiles', 'foto_path')) {
            Schema::table('pelamar_profiles', function (Blueprint $table) {
                $table->string('foto_path')->nullable()->after('bio');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pelamar_profiles', 'foto_path')) {
            Schema::table('pelamar_profiles', function (Blueprint $table) {
                $table->dropColumn('foto_path');
            });
        }
    }
};
