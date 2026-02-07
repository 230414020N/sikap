<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexes = DB::select("
            SELECT DISTINCT INDEX_NAME AS name
            FROM INFORMATION_SCHEMA.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'users'
              AND COLUMN_NAME = 'invitation_token'
              AND INDEX_NAME <> 'PRIMARY'
        ");

        foreach ($indexes as $idx) {
            DB::statement('DROP INDEX `'.$idx->name.'` ON `users`');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->text('invitation_token')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('invitation_token', 255)->nullable()->change();
        });
    }
};
