<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\MateriPembelajaran;

class MateriPembelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materis = [
            [
                'tingkatan_id' => 1,
                'judul_materi' => 'Pengenalan Huruf Hijaiyah',
                'deskripsi' => 'Materi dasar huruf Hijaiyah untuk Iqra 1',
                'urutan' => 1
            ],
            // Tambahkan materi lain jika diperlukan
        ];

        foreach ($materis as $materi) {
            MateriPembelajaran::updateOrCreate(
                ['judul_materi' => $materi['judul_materi']],
                $materi
            );
        }

        $this->command->info('✅ Materi Pembelajaran berhasil di-seed!');

    }
}
