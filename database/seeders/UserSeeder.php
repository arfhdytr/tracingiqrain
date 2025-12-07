<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Murid;
use App\Models\PermintaanBimbingan;
use App\Models\PreferensiPertanyaan;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------------------------------
        // 1. Buat User Admin
        // ---------------------------------
        $adminUser = User::create([
            'username' => 'admin',
            'password' => Hash::make('@qira123'),
        ]);

        // Buat admin profile
        Admin::create([
            'user_id' => $adminUser->user_id,
            'nama_lengkap' => 'Administrator IQRAIN',
        ]);

        // Assign rolenya admin
        $adminUser->assignRole('admin');

        // ---------------------------------
        // 2. Buat User Mentor (Approved)
        // ---------------------------------
        $mentorUser = User::create([
            'username' => 'mentor',
            'password' => Hash::make('password'),
        ]);

        // Buat mentor profile
        Mentor::create([
            'user_id' => $mentorUser->user_id,
            'nama_lengkap' => 'Mentor Hebat',
            'email' => 'mentor@iqrain.com',
            'no_wa' => '081234567890',
            'status_approval' => 'approved', 
            'tgl_persetujuan' => now(),
        ]);

        // Assign rolenya mentor
        $mentorUser->assignRole('mentor');

        $mentorUser2 = User::create([
            'username' => 'hidayat',
            'password' => Hash::make('password'),
        ]);

        // Buat mentor profile
        Mentor::create([
            'user_id' => $mentorUser2->user_id,
            'nama_lengkap' => 'Akhmad Hidayat',
            'email' => 'dayat@iqrain.com',
            'no_wa' => '081234567890',
            'status_approval' => 'approved',
            'tgl_persetujuan' => now(),
        ]);

        // Assign rolenya mentor
        $mentorUser2->assignRole('mentor');

        $mentorUser3 = User::create([
            'username' => 'nadiem',
            'password' => Hash::make('password'),
        ]);

        // Buat mentor profile
        Mentor::create([
            'user_id' => $mentorUser3->user_id,
            'nama_lengkap' => 'Kak Nadiem',
            'email' => 'nadiem@iqrain.com',
            'no_wa' => '081234567890',
            'status_approval' => 'pending',
            'tgl_persetujuan' => now(),
        ]);

        // Assign rolenya mentor
        $mentorUser3->assignRole('mentor');

        $mentorUser4 = User::create([
            'username' => 'budi',
            'password' => Hash::make('password'),
        ]);

        // Buat mentor profile
        Mentor::create([
            'user_id' => $mentorUser4->user_id,
            'nama_lengkap' => 'Kak Budi',
            'email' => 'budi@iqrain.com',
            'no_wa' => '081234567890',
            'status_approval' => 'approved',
            'tgl_persetujuan' => now(),
        ]);

        // Assign rolenya mentor
        $mentorUser4->assignRole('mentor');

        // ---------------------------------
        // 3. Buat User Murid
        // ---------------------------------
        $muridUser = User::create([
            'username' => 'murid',
            'password' => Hash::make('password'),
        ]);

        // Buat murid profile
        $murid = Murid::create([
            'user_id' => $muridUser->user_id,
            'sekolah' => 'SDN 1 Maju Jaya',
            'preferensi_terisi' => true,
        ]);

        // Assign rolenya murid
        $muridUser->assignRole('murid');

        // ---------------------------------
        // 4. Buat Preferensi Pertanyaan untuk Murid
        // ---------------------------------
        PreferensiPertanyaan::create([
            'murid_id' => $murid->murid_id,
            'pertanyaan' => 'Apa warna kesukaan kamu?',
            'jawaban' => Hash::make('merah'),
        ]);

        // ---------------------------------
        // 5. Buat Permintaan Bimbingan yang Sudah Disetujui
        // ---------------------------------
        $mentor = Mentor::where('user_id', $mentorUser->user_id)->first();

        PermintaanBimbingan::create([
            'murid_id' => $murid->murid_id,
            'mentor_id' => $mentor->mentor_id,
            'status' => 'approved',
            'tanggal_permintaan' => now()->subDays(7), // 7 hari yang lalu
            'tanggal_respons' => now()->subDays(6),    // 6 hari yang lalu
            'catatan' => 'Saya ingin belajar Iqra dengan Anda',
        ]);

        // Update mentor_id di tabel murid setelah permintaan disetujui
        $murid->update(['mentor_id' => $mentor->mentor_id]);

        // ---------------------------------
        // A. Tambah 2 Murid yang SUDAH MENJADI ANAK DIDIK (Approved)
        // ---------------------------------
        for ($i = 1; $i <= 2; $i++) {
            $userAnak = User::create([
                'username' => 'adik' . $i,
                'password' => Hash::make('password'),
            ]);
            $userAnak->assignRole('murid');

            $muridAnak = Murid::create([
                'user_id' => $userAnak->user_id,
                'sekolah' => 'SD Islam Harapan ' . $i,
                'preferensi_terisi' => true,
                'mentor_id' => $mentor->mentor_id,
            ]);

            // Buat preferensi dummy
            PreferensiPertanyaan::create([
                'murid_id' => $muridAnak->murid_id,
                'pertanyaan' => 'Apa warna kesukaan kamu?',
                'jawaban' => Hash::make('biru'),
            ]);

            // Buat record permintaan bimbingan (Status: Approved)
            PermintaanBimbingan::create([
                'murid_id' => $muridAnak->murid_id,
                'mentor_id' => $mentor->mentor_id,
                'status' => 'approved',
                'tanggal_permintaan' => now()->subDays(10 + $i),
                'tanggal_respons' => now()->subDays(9 + $i),
                'catatan' => 'Mohon bimbingannya kak agar saya pintar',
            ]);
        }


        // ---------------------------------
        // B. Tambah 3 Murid yang MASIH MENUNGGU KONFIRMASI (Pending)
        // ---------------------------------
        for ($j = 1; $j <= 3; $j++) {
            $userCalon = User::create([
                'username' => 'kids' . $j,
                'password' => Hash::make('password'),
            ]);
            $userCalon->assignRole('murid');

            $muridCalon = Murid::create([
                'user_id' => $userCalon->user_id,
                'sekolah' => 'SDI 3 Kota ' . $j,
                'preferensi_terisi' => true,
                'mentor_id' => null, 
            ]);

            // Buat preferensi dummy
            PreferensiPertanyaan::create([
                'murid_id' => $muridCalon->murid_id,
                'pertanyaan' => 'Apa warna kesukaan kamu?',
                'jawaban' => Hash::make('hijau'),
            ]);

            // Buat record permintaan bimbingan (Status: Pending)
            PermintaanBimbingan::create([
                'murid_id' => $muridCalon->murid_id,
                'mentor_id' => $mentor->mentor_id, // Mengarah ke mentor yang sama
                'status' => 'pending',
                'tanggal_permintaan' => now()->subHours($j * 2), // Baru request beberapa jam lalu
                'catatan' => 'Halo kak, saya ingin diajar ngaji dong. Saya calon ke-' . $j,
            ]);
        }
    }
}
