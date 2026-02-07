<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'logo')) {
                $table->string('logo')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('companies', 'banner')) {
                $table->string('banner')->nullable()->after('logo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'banner')) $table->dropColumn('banner');
            if (Schema::hasColumn('companies', 'logo')) $table->dropColumn('logo');
        });
    }
};
