<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Mentor;
use App\Models\Murid;

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
            'status_approval' => 'approved', // Set 'approved' agar bisa login
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
        Murid::create([
            'user_id' => $muridUser->user_id,
            'sekolah' => 'SDN 1 Maju Jaya',
            'preferensi_terisi' => false,
        ]);

        // Assign rolenya murid
        $muridUser->assignRole('murid');
    }
}
