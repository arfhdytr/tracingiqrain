<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VideoPembelajaran;

class VideoPembelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Alif',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Alif'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ba',
                'video_path' => 'https://www.youtube.com/embed/II5RkguUQ6I',
                'deskripsi' => 'Video pengenalan huruf Ba'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ta',
                'video_path' => 'https://www.youtube.com/embed/5S0B1Jv1s3U',
                'deskripsi' => 'Video pengenalan huruf Ta'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Tsa',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Tsa'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Jim',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Jim'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Kha',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Kha'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Kho',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Kho'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Dal',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Dal'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Dzal',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Dzal'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ra',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Ra'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Za',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Za'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Sin',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Sin'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Syin',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Syin'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Sad',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Sad'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Dhod',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Dhod'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Tho',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Tha'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Dhlo',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Dhlo'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ain',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Ain'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ghoin',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Ghoin'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Fa',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Fa'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Qof',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Qof'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Kaf',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Kaf'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Lam',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Lam'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Mim',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Mim'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Nun',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Nun'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Wawu',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Wawu'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ha',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Ha'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Lam Alif',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Lam Alif'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Hamzah',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Hamzah'
            ],
            [
                'tingkatan_id' => 1,
                'judul_video' => 'Ya',
                'video_path' => 'https://www.youtube.com/embed/wJpA6oMEwM0',
                'deskripsi' => 'Video pengenalan huruf Ya'
            ],
        ];

        foreach ($videos as $video) {
            VideoPembelajaran::updateOrCreate(
                ['judul_video' => $video['judul_video']],
                $video
            );
        }
    }
}
