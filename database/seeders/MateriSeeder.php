<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modul;

class MateriSeeder extends Seeder
{
   public function run()
    {
        $hurufs = [
            [
                'materi_id' => 1,
                'judul_modul' => 'Alif',
                'konten_teks' => 'Huruf Alif',
                'gambar_path' => 'alif.webp',
                'teks_latin' => 'Alif',
                'urutan' => 1
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ba',
                'konten_teks' => 'Huruf Ba',
                'gambar_path' => 'ba.webp',
                'teks_latin' => 'Ba',
                'urutan' => 2
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ta',
                'konten_teks' => 'Huruf Ta',
                'gambar_path' => 'ta.webp',
                'teks_latin' => 'Ta',
                'urutan' => 3
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Tsa',
                'konten_teks' => 'Huruf Tsa',
                'gambar_path' => 'tsa.webp',
                'teks_latin' => 'Tsa',
                'urutan' => 4
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Jim',
                'konten_teks' => 'Huruf Jim',
                'gambar_path' => 'jim.webp',
                'teks_latin' => 'Jim',
                'urutan' => 5
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Kha',
                'konten_teks' => 'Huruf Kha',
                'gambar_path' => 'Kha.webp',
                'teks_latin' => 'Kha',
                'urutan' => 6
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Kho',
                'konten_teks' => 'Huruf Kho',
                'gambar_path' => 'kho.webp',
                'teks_latin' => 'Kho',
                'urutan' => 7
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Dal',
                'konten_teks' => 'Huruf Dal',
                'gambar_path' => 'dal.webp',
                'teks_latin' => 'Dal',
                'urutan' => 8
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Dzal',
                'konten_teks' => 'Huruf Dzal',
                'gambar_path' => 'dzal.webp',
                'teks_latin' => 'Dzal',
                'urutan' => 9
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ra',
                'konten_teks' => 'Huruf Ra',
                'gambar_path' => 'ra.webp',
                'teks_latin' => 'Ra',
                'urutan' => 10
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Za',
                'konten_teks' => 'Huruf Za',
                'gambar_path' => 'Za.webp',
                'teks_latin' => 'Za',
                'urutan' => 11
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Sin',
                'konten_teks' => 'Huruf Sin',
                'gambar_path' => 'sin.webp',
                'teks_latin' => 'Sin',
                'urutan' => 12
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Syin',
                'konten_teks' => 'Huruf Syin',
                'gambar_path' => 'syin.webp',
                'teks_latin' => 'Syin',
                'urutan' => 13
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Sad',
                'konten_teks' => 'Huruf Sad',
                'gambar_path' => 'Shod.webp',
                'teks_latin' => 'Sad',
                'urutan' => 14
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Dhod',
                'konten_teks' => 'Huruf Dhod',
                'gambar_path' => 'Dhod.webp',
                'teks_latin' => 'Dhod',
                'urutan' => 15
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Tho',
                'konten_teks' => 'Huruf Tha',
                'gambar_path' => 'Tho.webp',
                'teks_latin' => 'Tho',
                'urutan' => 16
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Dhlo',
                'konten_teks' => 'Huruf Dhlo',
                'gambar_path' => 'Dhlo.webp',
                'teks_latin' => 'Dhlo',
                'urutan' => 17
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ain',
                'konten_teks' => 'Huruf Ain',
                'gambar_path' => 'ain.webp',
                'teks_latin' => 'Ain',
                'urutan' => 18
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ghoin',
                'konten_teks' => 'Huruf Ghoin',
                'gambar_path' => 'Ghoin.webp',
                'teks_latin' => 'Ghoin',
                'urutan' => 19
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Fa',
                'konten_teks' => 'Huruf Fa',
                'gambar_path' => 'fa.webp',
                'teks_latin' => 'Fa',
                'urutan' => 20
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Qof',
                'konten_teks' => 'Huruf Qof',
                'gambar_path' => 'Qof.webp',
                'teks_latin' => 'Qof',
                'urutan' => 21
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Kaf',
                'konten_teks' => 'Huruf Kaf',
                'gambar_path' => 'kaf.webp',
                'teks_latin' => 'Kaf',
                'urutan' => 22
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Lam',
                'konten_teks' => 'Huruf Lam',
                'gambar_path' => 'lam.webp',
                'teks_latin' => 'Lam',
                'urutan' => 23
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Mim',
                'konten_teks' => 'Huruf Mim',
                'gambar_path' => 'mim.webp',
                'teks_latin' => 'Mim',
                'urutan' => 24
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Nun',
                'konten_teks' => 'Huruf Nun',
                'gambar_path' => 'nun.webp',
                'teks_latin' => 'Nun',
                'urutan' => 25
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Wawu',
                'konten_teks' => 'Huruf Wawu',
                'gambar_path' => 'Wawu.webp',
                'teks_latin' => 'Wawu',
                'urutan' => 26
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ha',
                'konten_teks' => 'Huruf Ha',
                'gambar_path' => 'Ha.webp',
                'teks_latin' => 'Ha',
                'urutan' => 27
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Lam Alif',
                'konten_teks' => 'Huruf Lam Alif',
                'gambar_path' => 'Lamalif.webp',
                'teks_latin' => 'Lam Alif',
                'urutan' => 28
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Hamzah',
                'konten_teks' => 'Huruf Hamzah',
                'gambar_path' => 'hamzah.webp',
                'teks_latin' => 'Hamzah',
                'urutan' => 29
            ],
            [
                'materi_id' => 1,
                'judul_modul' => 'Ya',
                'konten_teks' => 'Huruf Ya',
                'gambar_path' => 'ya.webp',
                'teks_latin' => 'Ya',
                'urutan' => 30
            ],
        ];

        foreach ($hurufs as $huruf) {
            Modul::updateOrCreate(
                [
                    'judul_modul' => $huruf['judul_modul'],
                    'materi_id' => $huruf['materi_id']
                ],
                $huruf
            );
        }

        $this->command->info('✅ 30 Huruf Hijaiyah berhasil di-seed!');
    }
}
