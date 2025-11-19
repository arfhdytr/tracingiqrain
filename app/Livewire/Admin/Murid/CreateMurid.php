<?php
// app/Livewire/Admin/Murid/CreateMurid.php (rename dari Create.php)

namespace App\Livewire\Admin\Murid;

use App\Models\User;
use App\Models\Murid;
use App\Models\Mentor;
use App\Models\PreferensiPertanyaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateMurid extends Component
{
    // User fields
    public $username = '';
    public $password = '';
    public $password_confirmation = '';

    // Murid fields
    public $mentor_id = '';
    public $sekolah = '';

    // Preferensi fields
    public $pertanyaan = 'Apa warna kesukaan kamu?';
    public $jawaban = '';

    protected function rules()
    {
        return [
            'username' => 'required|string|min:3|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
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
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
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

            // 1. Create User
            $user = User::create([
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

            // 2. Assign role murid
            $user->assignRole('murid');

            // 3. Create Murid profile
            $murid = Murid::create([
                'user_id' => $user->user_id,
                'mentor_id' => $this->mentor_id ?: null,
                'sekolah' => $this->sekolah ?: null,
                'preferensi_terisi' => true,
            ]);

            // 4. Create Preferensi Pertanyaan
            PreferensiPertanyaan::create([
                'murid_id' => $murid->murid_id,
                'pertanyaan' => $this->pertanyaan,
                'jawaban' => $this->jawaban,
            ]);

            DB::commit();

            session()->flash('success', 'Murid "' . $this->username . '" berhasil ditambahkan!');

            return redirect()->route('admin.murid.index');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Gagal menambahkan murid: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $mentors = Mentor::with('user')
            ->approved()
            ->orderBy('nama_lengkap')
            ->get();

        return view('livewire.admin.murid.create-murid', [
            'mentors' => $mentors,
        ]);
    }
}
