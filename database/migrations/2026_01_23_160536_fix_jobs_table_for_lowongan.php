<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'job_id')) {
            try {
                Schema::table('applications', function (Blueprint $table) {
                    $table->dropForeign(['job_id']);
                });
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('jobs') && Schema::hasColumn('jobs', 'payload') && Schema::hasColumn('jobs', 'queue')) {
            if (!Schema::hasTable('queue_jobs')) {
                Schema::rename('jobs', 'queue_jobs');
            } else {
                Schema::drop('jobs');
            }
        }

        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
                $table->string('judul');
                $table->string('lokasi')->nullable();
                $table->string('tipe', 100)->nullable();
                $table->string('level', 100)->nullable();
                $table->string('kategori', 100)->nullable();
                $table->unsignedBigInteger('gaji_min')->nullable();
                $table->unsignedBigInteger('gaji_max')->nullable();
                $table->longText('deskripsi')->nullable();
                $table->longText('kualifikasi')->nullable();
                $table->date('deadline')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index(['company_id', 'is_active']);
            });
        }

        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'job_id')) {
            try {
                Schema::table('applications', function (Blueprint $table) {
                    $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnDelete();
                });
            } catch (\Throwable $e) {
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'job_id')) {
            try {
                Schema::table('applications', function (Blueprint $table) {
                    $table->dropForeign(['job_id']);
                });
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('jobs') && Schema::hasColumn('jobs', 'judul')) {
            Schema::drop('jobs');
        }

        if (Schema::hasTable('queue_jobs') && !Schema::hasTable('jobs')) {
            Schema::rename('queue_jobs', 'jobs');
        }

        if (Schema::hasTable('applications') && Schema::hasColumn('applications', 'job_id')) {
            try {
                Schema::table('applications', function (Blueprint $table) {
                    $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnDelete();
                });
            } catch (\Throwable $e) {
            }
        }
    }
};
