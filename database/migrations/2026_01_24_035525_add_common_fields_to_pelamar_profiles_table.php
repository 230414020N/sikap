<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelamar_profiles', function (Blueprint $table) {
            // Foto / avatar
            $table->string('foto_path')->nullable()->after('bio');

            // Data personal umum
            $table->date('tanggal_lahir')->nullable()->after('foto_path');
            $table->string('jenis_kelamin', 20)->nullable()->after('tanggal_lahir'); // mis: pria/wanita/lainnya
            $table->string('domisili')->nullable()->after('jenis_kelamin');          // kota/dom
            $table->string('kode_pos', 10)->nullable()->after('domisili');

            // “Headline” dan link profesional
            $table->string('headline')->nullable()->after('kode_pos');              // contoh: "UI/UX Designer | 2 tahun pengalaman"
            $table->string('linkedin_url')->nullable()->after('headline');
            $table->string('github_url')->nullable()->after('linkedin_url');
            $table->string('portfolio_url')->nullable()->after('github_url');

            // Skill & bahasa (lebih fleksibel pakai JSON)
            $table->json('keterampilan')->nullable()->after('portfolio_url');       // ["Laravel","MySQL","Figma"]
            $table->json('bahasa')->nullable()->after('keterampilan');              // ["Indonesia","English"]

            // Preferensi kerja umum
            $table->string('posisi_diinginkan')->nullable()->after('bahasa');
            $table->integer('gaji_harapan')->nullable()->after('posisi_diinginkan'); // rupiah
            $table->date('ketersediaan_mulai')->nullable()->after('gaji_harapan');

            // Kontak darurat (opsional tapi umum)
            $table->string('kontak_darurat_nama')->nullable()->after('ketersediaan_mulai');
            $table->string('kontak_darurat_hp', 20)->nullable()->after('kontak_darurat_nama');
        });
    }

    public function down(): void
    {
        Schema::table('pelamar_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'foto_path',
                'tanggal_lahir',
                'jenis_kelamin',
                'domisili',
                'kode_pos',
                'headline',
                'linkedin_url',
                'github_url',
                'portfolio_url',
                'keterampilan',
                'bahasa',
                'posisi_diinginkan',
                'gaji_harapan',
                'ketersediaan_mulai',
                'kontak_darurat_nama',
                'kontak_darurat_hp',
            ]);
        });
    }
};
