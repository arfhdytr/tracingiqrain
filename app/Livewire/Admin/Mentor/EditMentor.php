<?php
// app/Livewire/Admin/Mentor/EditMentor.php

namespace App\Livewire\Admin\Mentor;

use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditMentor extends Component
{
    public Mentor $mentor;

    // User fields
    public $username = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Mentor fields
    public $nama_lengkap = '';
    public $email = '';
    public $no_wa = '';

    public function mount(Mentor $mentor)
    {
        $this->mentor = $mentor;

        // Load current data
        $this->username = $this->mentor->user->username;
        $this->nama_lengkap = $this->mentor->nama_lengkap;
        $this->email = $this->mentor->email;
        $this->no_wa = $this->mentor->no_wa ?? '';
    }

    protected function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username,' . $this->mentor->user_id . ',user_id',
            'new_password' => 'nullable|string|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:mentors,email,' . $this->mentor->mentor_id . ',mentor_id',
            'no_wa' => 'nullable|string|max:20',
        ];
    }

    protected $messages = [
        'username.required' => 'Username wajib diisi',
        'username.unique' => 'Username sudah digunakan',
        'username.min' => 'Username minimal 3 karakter',
        'new_password.min' => 'Password minimal 6 karakter',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok',
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

            // 1. Update User
            $userData = ['username' => $this->username];

            if (!empty($this->new_password)) {
                $userData['password'] = Hash::make($this->new_password);
            }

            $this->mentor->user->update($userData);

            // 2. Update Mentor profile
            $this->mentor->update([
                'nama_lengkap' => $this->nama_lengkap,
                'email' => $this->email,
                'no_wa' => $this->no_wa ?: null,
            ]);

            DB::commit();

            session()->flash('success', 'Data mentor "' . $this->nama_lengkap . '" berhasil diperbarui!');

            return redirect()->route('admin.mentor.index');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Gagal memperbarui mentor: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.mentor.edit-mentor');
    }
}
