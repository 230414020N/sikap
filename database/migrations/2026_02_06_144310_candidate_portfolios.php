<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('candidate_portfolios')) {
            Schema::create('candidate_portfolios', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();
                $table->unsignedBigInteger('candidate_id');
                $table->string('title')->nullable();
                $table->string('url')->nullable();
                $table->string('file_path')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();

                $table->index('candidate_id');
            });
        }

        $parentTable = 'pelamar';

        if (Schema::hasTable($parentTable)) {
            $fk = DB::selectOne("
                SELECT 1 AS ok
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'candidate_portfolios'
                  AND COLUMN_NAME = 'candidate_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            if (!$fk) {
                Schema::table('candidate_portfolios', function (Blueprint $table) use ($parentTable) {
                    $table->foreign('candidate_id')->references('id')->on($parentTable)->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('candidate_portfolios')) {
            Schema::drop('candidate_portfolios');
        }
    }
};
