<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
                $table->string('judul');
                $table->string('lokasi')->nullable();
                $table->string('tipe', 100)->nullable();
                $table->string('level', 100)->nullable();
                $table->string('kategori', 100)->nullable();
                $table->decimal('gaji_min', 12, 2)->nullable();
                $table->decimal('gaji_max', 12, 2)->nullable();
                $table->longText('deskripsi')->nullable();
                $table->longText('kualifikasi')->nullable();
                $table->date('deadline')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            return;
        }

        Schema::table('jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('jobs', 'company_id')) {
                $table->foreignId('company_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('jobs', 'judul')) {
                $table->string('judul')->nullable();
            }

            if (!Schema::hasColumn('jobs', 'lokasi')) {
                $table->string('lokasi')->nullable();
            }

            if (!Schema::hasColumn('jobs', 'tipe')) {
                $table->string('tipe', 100)->nullable();
            }

            if (!Schema::hasColumn('jobs', 'level')) {
                $table->string('level', 100)->nullable();
            }

            if (!Schema::hasColumn('jobs', 'kategori')) {
                $table->string('kategori', 100)->nullable();
            }

            if (!Schema::hasColumn('jobs', 'gaji_min')) {
                $table->decimal('gaji_min', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('jobs', 'gaji_max')) {
                $table->decimal('gaji_max', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('jobs', 'deskripsi')) {
                $table->longText('deskripsi')->nullable();
            }

            if (!Schema::hasColumn('jobs', 'kualifikasi')) {
                $table->longText('kualifikasi')->nullable();
            }

            if (!Schema::hasColumn('jobs', 'deadline')) {
                $table->date('deadline')->nullable();
            }

            if (!Schema::hasColumn('jobs', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }

            if (!Schema::hasColumn('jobs', 'created_at') && !Schema::hasColumn('jobs', 'updated_at')) {
                $table->timestamps();
            }
        });

        if (Schema::hasColumn('jobs', 'company_id')) {
            $fk = DB::selectOne("
                SELECT 1 AS ok
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'jobs'
                  AND COLUMN_NAME = 'company_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            if (!$fk) {
                Schema::table('jobs', function (Blueprint $table) {
                    $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('jobs')) {
            Schema::drop('jobs');
        }
    }
};
