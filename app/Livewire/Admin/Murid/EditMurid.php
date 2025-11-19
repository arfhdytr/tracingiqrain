<?php
// app/Livewire/Admin/Murid/EditMurid.php (rename dari Edit.php)

namespace App\Livewire\Admin\Murid;

use App\Models\Murid;
use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditMurid extends Component
{
    public Murid $murid;

    // User fields
    public $username = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    // Murid fields
    public $mentor_id = '';
    public $sekolah = '';

    // Preferensi fields
    public $pertanyaan = '';
    public $jawaban = '';

    public function mount(Murid $murid)
    {
        $this->murid = $murid;

        // Load current data
        $this->username = $this->murid->user->username;
        $this->mentor_id = $this->murid->mentor_id ?? '';
        $this->sekolah = $this->murid->sekolah ?? '';

        // Load preferensi if exists
        if ($this->murid->preferensiPertanyaan) {
            $this->pertanyaan = $this->murid->preferensiPertanyaan->pertanyaan;
            $this->jawaban = $this->murid->preferensiPertanyaan->jawaban;
        } else {
            $this->pertanyaan = 'Apa warna kesukaan kamu?';
        }
    }

    protected function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username,' . $this->murid->user_id . ',user_id',
            'new_password' => 'nullable|string|min:6|confirmed',
            'mentor_id' => 'nullable|exists:mentors,mentor_id',
            'sekolah' => 'nullable|string|max:100',
            'pertanyaan' => 'required|string|max:100',
            'jawaban' => 'required|string|max:255',
        ];
    }

    protected $messages = [
        'username.required' => 'Username wajib diisi',
        'username.unique' => 'Username sudah digunakan',
        'username.min' => 'Username minimal 3 karakter',
        'new_password.min' => 'Password minimal 6 karakter',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        'mentor_id.exists' => 'Mentor tidak valid',
        'jawaban.required' => 'Jawaban preferensi wajib diisi',
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

            // 2. Update Murid profile
            $this->murid->update([
                'mentor_id' => $this->mentor_id ?: null,
                'sekolah' => $this->sekolah ?: null,
                'preferensi_terisi' => !empty($this->jawaban),
            ]);

            // 3. Update or Create Preferensi Pertanyaan
            $this->murid->preferensiPertanyaan()->updateOrCreate(
                ['murid_id' => $this->murid->murid_id],
                [
                    'pertanyaan' => $this->pertanyaan,
                    'jawaban' => $this->jawaban,
                ]
            );

            DB::commit();

            session()->flash('success', 'Data murid "' . $this->username . '" berhasil diperbarui!');

            return redirect()->route('admin.murid.index');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Gagal memperbarui murid: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $mentors = Mentor::with('user')
            ->approved()
            ->orderBy('nama_lengkap')
            ->get();

        return view('livewire.admin.murid.edit-murid', [
            'mentors' => $mentors,
        ]);
    }
}
