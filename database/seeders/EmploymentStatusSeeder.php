<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EmploymentStatusSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Karyawan Tetap',
            'Karyawan Kontrak',
            'Freelancer',
            'Wiraswasta',
            'Pelajar/Mahasiswa',
            'Ibu Rumah Tangga',
            'Belum Bekerja',
            'PNS/ASN',
        ];

        foreach ($items as $name) {
            DB::table('employment_statuses')->updateOrInsert(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
