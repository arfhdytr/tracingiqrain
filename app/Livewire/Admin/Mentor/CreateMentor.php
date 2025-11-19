<?php
// app/Livewire/Admin/Mentor/CreateMentor.php

namespace App\Livewire\Admin\Mentor;

use App\Models\User;
use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateMentor extends Component
{
    // User fields
    public $username = '';
    public $password = '';
    public $password_confirmation = '';

    // Mentor fields
    public $nama_lengkap = '';
    public $email = '';
    public $no_wa = '';

    protected function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:mentors,email',
            'no_wa' => 'nullable|string|max:20',
        ];
    }

    protected $messages = [
        'username.required' => 'Username wajib diisi',
        'username.unique' => 'Username sudah digunakan',
        'username.min' => 'Username minimal 3 karakter',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'nama_lengkap.required' => 'Nama lengkap wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // 1. Create User
            $user = User::create([
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

            // 2. Assign role mentor
            $user->assignRole('mentor');

            // 3. Create Mentor profile
            Mentor::create([
                'user_id' => $user->user_id,
                'nama_lengkap' => $this->nama_lengkap,
                'email' => $this->email,
                'no_wa' => $this->no_wa ?: null,
                'status_approval' => 'approved', // Langsung approved karena dibuat admin
                'tgl_persetujuan' => now(),
            ]);

            DB::commit();

            session()->flash('success', 'Mentor "' . $this->nama_lengkap . '" berhasil ditambahkan!');

            return redirect()->route('admin.mentor.index');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Gagal menambahkan mentor: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.mentor.create-mentor');
    }
}
