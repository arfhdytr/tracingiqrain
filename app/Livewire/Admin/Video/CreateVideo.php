<?php
// app/Livewire/Admin/Video/CreateVideo.php

namespace App\Livewire\Admin\Video;

use App\Models\VideoPembelajaran;
use App\Models\TingkatanIqra;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateVideo extends Component
{
    use WithFileUploads;

    public $tingkatan_id = '';
    public $judul_video = '';
    public $deskripsi = '';
    public $video_file;
    public $subtitle_file;

    protected function rules()
    {
        return [
            'tingkatan_id' => 'required|exists:tingkatan_iqras,tingkatan_id',
            'judul_video' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'video_file' => 'required|file|mimes:mp4,mov,avi,wmv|max:102400', // Max 100MB
            'subtitle_file' => 'nullable|file|mimes:srt,vtt,txt|max:2048', // Max 2MB
        ];
    }

    protected $messages = [
        'tingkatan_id.required' => 'Tingkatan Iqra wajib dipilih',
        'tingkatan_id.exists' => 'Tingkatan Iqra tidak valid',
        'judul_video.required' => 'Judul video wajib diisi',
        'video_file.required' => 'File video wajib diunggah',
        'video_file.mimes' => 'Format video harus mp4, mov, avi, atau wmv',
        'video_file.max' => 'Ukuran video maksimal 100MB',
        'subtitle_file.mimes' => 'Format subtitle harus srt, vtt, atau txt',
        'subtitle_file.max' => 'Ukuran subtitle maksimal 2MB',
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

            // Upload video file
            $videoPath = $this->video_file->store('videos', 'public');

            // Upload subtitle file jika ada
            $subtitlePath = null;
            if ($this->subtitle_file) {
                $subtitlePath = $this->subtitle_file->store('subtitles', 'public');
            }

            // Create video record
            VideoPembelajaran::create([
                'tingkatan_id' => $this->tingkatan_id,
                'judul_video' => $this->judul_video,
                'deskripsi' => $this->deskripsi,
                'video_path' => $videoPath,
                'subtitle_path' => $subtitlePath,
            ]);

            DB::commit();

            session()->flash('success', 'Video "' . $this->judul_video . '" berhasil ditambahkan!');

            return redirect()->route('admin.video.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah diupload jika ada error
            if (isset($videoPath) && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }
            if (isset($subtitlePath) && Storage::disk('public')->exists($subtitlePath)) {
                Storage::disk('public')->delete($subtitlePath);
            }

            session()->flash('error', 'Gagal menambahkan video: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $tingkatans = TingkatanIqra::orderBy('level')->get();

        return view('livewire.admin.video.create-video', [
            'tingkatans' => $tingkatans,
        ]);
    }
}
