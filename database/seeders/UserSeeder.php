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
            'password' => Hash::make('password'),
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
    }
}
