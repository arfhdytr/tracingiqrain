<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MateriPembelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $tingkatanId = 1;

        $materiList = [
            'Alif',
            'Ba',
            'Ta',
            'Tsa',
            'Jim',
            'Kha', 
            'Kho', 
            'Dal',
            'Dzal',
            'Ra',
            'Zai',
            'Sin',
            'Syin',
            'Sad',
            'Dhad',
            'Tha',
            'Zha', 
            'Ain',
            'Ghain',
            'Fa',
            'Qaf',
            'Kaf',
            'Lam',
            'Mim',
            'Nun',
            'Waw',
            'Ha',
            'Lamalif',
            'Hamzah',
            'Ya'
        ];

        $data = [];
        $urutan = 1;

        foreach ($materiList as $namaMateri) {
            $data[] = [
                'tingkatan_id' => $tingkatanId,
                'judul_materi' => $namaMateri,
                'deskripsi' => 'Pengenalan dan cara membaca huruf ' . $namaMateri . ' dengan harakat Fathah.',
                'urutan' => $urutan++,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        // Masukkan semua data sekaligus
        DB::table('materi_pembelajarans')->insert($data);
    }
}
