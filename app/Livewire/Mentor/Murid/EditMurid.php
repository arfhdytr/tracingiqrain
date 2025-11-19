<?php
// app/Livewire/Mentor/Murid/EditMurid.php

namespace App\Livewire\Mentor\Murid;

use App\Models\Murid;
use App\Models\PreferensiPertanyaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditMurid extends Component
{
    // Fixed question
    public const PERTANYAAN_PREFERENSI = 'Apa warna kesukaanmu?';

    public Murid $murid;

    // User fields
    public $username = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Murid fields
    public $sekolah = '';

    // Preferensi fields
    public $jawaban_preferensi = '';

    public function mount(Murid $murid)
    {
        // Authorization check
        $mentor = Auth::user()->mentor;

        if ($murid->mentor_id !== $mentor->mentor_id) {
            abort(403, 'Unauthorized action.');
        }

        $this->murid = $murid;

        // Load current data
        $this->username = $this->murid->user->username;
        $this->sekolah = $this->murid->sekolah ?? '';

        // Load preferensi
        $preferensi = $this->murid->preferensiPertanyaan;
        if ($preferensi) {
            $this->jawaban_preferensi = $preferensi->jawaban;
        }
    }

    protected function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username,' . $this->murid->user_id . ',user_id',
            'new_password' => 'nullable|string|min:6|confirmed',
            'sekolah' => 'nullable|string|max:100',
            'jawaban_preferensi' => 'required|string|max:255',
        ];
    }

    protected $messages = [
        'username.required' => 'Username wajib diisi',
        'username.unique' => 'Username sudah digunakan',
        'username.min' => 'Username minimal 3 karakter',
        'new_password.min' => 'Password minimal 6 karakter',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        'jawaban_preferensi.required' => 'Jawaban preferensi wajib diisi',
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

            $this->murid->user->update($userData);

            // 2. Update Murid
            $this->murid->update([
                'sekolah' => $this->sekolah ?: null,
            ]);

            // 3. Update or Create Preferensi Pertanyaan dengan pertanyaan fixed
            PreferensiPertanyaan::updateOrCreate(
                ['murid_id' => $this->murid->murid_id],
                [
                    'pertanyaan' => self::PERTANYAAN_PREFERENSI,
                    'jawaban' => $this->jawaban_preferensi,
                ]
            );

            DB::commit();

            session()->flash('success', 'Data murid "' . $this->username . '" berhasil diperbarui!');

            return redirect()->route('mentor.murid.index');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Gagal memperbarui murid: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.mentor.murid.edit-murid');
    }
}
