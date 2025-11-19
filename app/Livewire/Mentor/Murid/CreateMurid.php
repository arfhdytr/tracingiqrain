<?php
// app/Livewire/Mentor/Murid/CreateMurid.php

namespace App\Livewire\Mentor\Murid;

use App\Models\User;
use App\Models\Murid;
use App\Models\PreferensiPertanyaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use League\Csv\Reader;

class CreateMurid extends Component
{
    use WithFileUploads;

    // Fixed question
    public const PERTANYAAN_PREFERENSI = 'Apa warna kesukaanmu?';

    // Mode: 'manual' atau 'csv'
    public $mode = 'manual';

    // Manual input
    public $username = '';
    public $password = '';
    public $sekolah = '';
    public $jawaban_preferensi = '';

    // CSV upload
    public $csv_file;
    public $import_summary = null;

    protected function rules()
    {
        if ($this->mode === 'manual') {
            return [
                'username' => 'required|string|min:3|max:50|unique:users,username',
                'password' => 'required|string|min:6',
                'sekolah' => 'nullable|string|max:100',
                'jawaban_preferensi' => 'required|string|max:255',
            ];
        } else {
            return [
                'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            ];
        }
    }

    protected $messages = [
        'username.required' => 'Username wajib diisi',
        'username.unique' => 'Username sudah digunakan',
        'username.min' => 'Username minimal 3 karakter',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'jawaban_preferensi.required' => 'Jawaban preferensi wajib diisi',
        'csv_file.required' => 'File CSV wajib diunggah',
        'csv_file.mimes' => 'File harus berformat CSV',
        'csv_file.max' => 'Ukuran file maksimal 2MB',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        if ($this->mode === 'manual') {
            return $this->saveManual();
        } else {
            return $this->saveCsv();
        }
    }

    private function saveManual()
    {
        try {
            DB::beginTransaction();

            $mentor = Auth::user()->mentor;

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
                'mentor_id' => $mentor->mentor_id,
                'sekolah' => $this->sekolah ?: null,
                'preferensi_terisi' => true,
            ]);

            // 4. Create Preferensi Pertanyaan dengan pertanyaan fixed
            PreferensiPertanyaan::create([
                'murid_id' => $murid->murid_id,
                'pertanyaan' => self::PERTANYAAN_PREFERENSI,
                'jawaban' => $this->jawaban_preferensi,
            ]);

            DB::commit();

            session()->flash('success', 'Murid "' . $this->username . '" berhasil ditambahkan!');

            return redirect()->route('mentor.murid.index');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Gagal menambahkan murid: ' . $e->getMessage());
        }
    }

    private function saveCsv()
    {
        try {
            $mentor = Auth::user()->mentor;

            // Read CSV
            $csv = Reader::createFromPath($this->csv_file->getRealPath(), 'r');
            $csv->setDelimiter(',');
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();

            $successCount = 0;
            $failedCount = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($records as $index => $record) {
                // dd($record);
                try {
                    // Validasi required fields (tanpa pertanyaan_preferensi)
                    if (
                        empty($record['username']) || empty($record['password']) ||
                        empty($record['jawaban_preferensi'])
                    ) {
                        throw new \Exception('Data tidak lengkap');
                    }

                    // Check username duplicate
                    if (User::where('username', $record['username'])->exists()) {
                        throw new \Exception('Username sudah digunakan');
                    }

                    // Create User
                    $user = User::create([
                        'username' => $record['username'],
                        'password' => Hash::make($record['password']),
                    ]);

                    $user->assignRole('murid');

                    // Create Murid
                    $murid = Murid::create([
                        'user_id' => $user->user_id,
                        'mentor_id' => $mentor->mentor_id,
                        'sekolah' => $record['sekolah'] ?? null,
                        'preferensi_terisi' => true,
                    ]);

                    // Create Preferensi dengan pertanyaan fixed
                    PreferensiPertanyaan::create([
                        'murid_id' => $murid->murid_id,
                        'pertanyaan' => self::PERTANYAAN_PREFERENSI,
                        'jawaban' => $record['jawaban_preferensi'],
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            $this->import_summary = [
                'success' => $successCount,
                'failed' => $failedCount,
                'errors' => $errors,
            ];

            if ($failedCount === 0) {
                session()->flash('success', "Berhasil mengimpor {$successCount} murid!");
                return redirect()->route('mentor.murid.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal mengimpor CSV: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.mentor.murid.create-murid');
    }
}
