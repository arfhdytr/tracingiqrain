<?php
// app/Livewire/Murid/MuridUpdateProfile.php

namespace App\Livewire\Murid;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MuridUpdateProfile extends Component
{
    use WithFileUploads;

    public $username;
    public $sekolah;
    public $warna_kesukaan;
    public $photo;
    public $currentPhoto;

    public $previousUrl;

    protected function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users')->ignore(Auth::id(), 'user_id')
            ],
            'sekolah' => ['nullable', 'string', 'max:255'],
            'warna_kesukaan' => ['required', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ];
    }

    protected $messages = [
        'username.required' => 'Username wajib diisi.',
        'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash, dan underscore.',
        'username.unique' => 'Username sudah digunakan.',
        'warna_kesukaan.required' => 'Warna kesukaan wajib diisi.',
        'photo.image' => 'File harus berupa gambar.',
        'photo.max' => 'Ukuran foto maksimal 1MB.',
    ];

    public function mount()
    {
        $user = Auth::user();
        $murid = $user->murid;

        $this->username = $user->username;
        $this->sekolah = $murid->sekolah ?? '';
        $this->currentPhoto = $user->avatar_path ? Storage::url($user->avatar_path) : $user->getAvatarUrlAttribute();

         // Ambil preferensi warna kesukaan jika ada

        if ($murid && $murid->preferensiPertanyaan) {
            $this->warna_kesukaan = $murid->preferensiPertanyaan->jawaban ?? '';
        } else {
            $this->warna_kesukaan = '';
        }

        $previous = url()->previous();
        $current = route('murid.profile'); // Asumsi route name profile adalah 'murid.profile'

        // Cek agar tidak terjadi loop (jika previous URL sama dengan halaman profile, set default ke pilih-iqra)
        if ($previous === $current || $previous === url()->current()) {
            $this->previousUrl = route('murid.pilih-iqra');
        } else {
            $this->previousUrl = $previous;
        }
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();
        $murid = $user->murid;

        // Update username
        $user->update([
            'username' => $this->username,
        ]);

        // Update sekolah dan set preferensi_terisi
        if ($murid) {
            $murid->update([
                'sekolah' => $this->sekolah,
                'preferensi_terisi' => true,
            ]);

            // Update atau create preferensi
            $murid->preferensiPertanyaan()->updateOrCreate(
                ['murid_id' => $murid->murid_id],
                [
                    'pertanyaan' => 'Apa warna kesukaan kamu?',
                    'jawaban' => $this->warna_kesukaan,
                ]
            );
        }

        // Update photo jika ada
        if ($this->photo) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $path = $this->photo->store('avatars', 'public');
            $user->update(['avatar_path' => $path]);

            $this->currentPhoto = Storage::url($path);
        }

        session()->flash('message', 'Profil berhasil diperbarui! 🎉');
        
        // Redirect dinamis ke URL yang sudah disimpan di mount()
        return redirect()->to($this->previousUrl);
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->update(['avatar_path' => null]);
            $this->currentPhoto = $user->getProfilePhotoUrl();

         // Ambil preferensi warna kesukaan jika ada

            // Dispatch event untuk SweetAlert
            $this->dispatch('show-success', message: 'Foto berhasil dihapus! 🗑️');
        }
    }

    public function render()
    {
        return view('livewire.murid.murid-update-profile')
            ->layout('layouts.murid-authentication');
    }
}
