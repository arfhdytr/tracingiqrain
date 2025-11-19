<?php
// app/Livewire/Admin/Video/EditVideo.php

namespace App\Livewire\Admin\Video;

use App\Models\VideoPembelajaran;
use App\Models\TingkatanIqra;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditVideo extends Component
{
    use WithFileUploads;

    public VideoPembelajaran $video;

    public $tingkatan_id = '';
    public $judul_video = '';
    public $deskripsi = '';
    public $new_video_file;
    public $new_subtitle_file;
    public $remove_subtitle = false;

    public function mount(VideoPembelajaran $video)
    {
        $this->video = $video;

        // Load current data
        $this->tingkatan_id = $this->video->tingkatan_id;
        $this->judul_video = $this->video->judul_video;
        $this->deskripsi = $this->video->deskripsi ?? '';
    }

    protected function rules()
    {
        return [
            'tingkatan_id' => 'required|exists:tingkatan_iqras,tingkatan_id',
            'judul_video' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'new_video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400', // Max 100MB
            'new_subtitle_file' => 'nullable|file|mimes:srt,vtt,txt|max:2048', // Max 2MB
        ];
    }

    protected $messages = [
        'tingkatan_id.required' => 'Tingkatan Iqra wajib dipilih',
        'tingkatan_id.exists' => 'Tingkatan Iqra tidak valid',
        'judul_video.required' => 'Judul video wajib diisi',
        'new_video_file.mimes' => 'Format video harus mp4, mov, avi, atau wmv',
        'new_video_file.max' => 'Ukuran video maksimal 100MB',
        'new_subtitle_file.mimes' => 'Format subtitle harus srt, vtt, atau txt',
        'new_subtitle_file.max' => 'Ukuran subtitle maksimal 2MB',
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

            $oldVideoPath = $this->video->video_path;
            $oldSubtitlePath = $this->video->subtitle_path;

            // Update video file jika ada
            $videoPath = $oldVideoPath;
            if ($this->new_video_file) {
                $videoPath = $this->new_video_file->store('videos', 'public');
            }

            // Update subtitle file
            $subtitlePath = $oldSubtitlePath;
            if ($this->new_subtitle_file) {
                $subtitlePath = $this->new_subtitle_file->store('subtitles', 'public');
            } elseif ($this->remove_subtitle) {
                $subtitlePath = null;
            }

            // Update video record
            $this->video->update([
                'tingkatan_id' => $this->tingkatan_id,
                'judul_video' => $this->judul_video,
                'deskripsi' => $this->deskripsi,
                'video_path' => $videoPath,
                'subtitle_path' => $subtitlePath,
            ]);

            // Hapus file lama jika ada file baru
            if ($this->new_video_file && $oldVideoPath && Storage::disk('public')->exists($oldVideoPath)) {
                Storage::disk('public')->delete($oldVideoPath);
            }

            if (($this->new_subtitle_file || $this->remove_subtitle) && $oldSubtitlePath && Storage::disk('public')->exists($oldSubtitlePath)) {
                Storage::disk('public')->delete($oldSubtitlePath);
            }

            DB::commit();

            session()->flash('success', 'Video "' . $this->judul_video . '" berhasil diperbarui!');

            return redirect()->route('admin.video.index');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file baru yang sudah diupload jika ada error
            if (isset($videoPath) && $videoPath !== $oldVideoPath && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }
            if (isset($subtitlePath) && $subtitlePath !== $oldSubtitlePath && Storage::disk('public')->exists($subtitlePath)) {
                Storage::disk('public')->delete($subtitlePath);
            }

            session()->flash('error', 'Gagal memperbarui video: ' . $e->getMessage());
        }
    }

    public function getFileSizeProperty()
    {
        if ($this->video->video_path && Storage::disk('public')->exists($this->video->video_path)) {
            $bytes = Storage::disk('public')->size($this->video->video_path);
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = 0;
            while ($bytes >= 1024 && $i < 3) {
                $bytes /= 1024;
                $i++;
            }
            return number_format($bytes, 2) . ' ' . $units[$i];
        }
        return '-';
    }

    public function render()
    {
        $tingkatans = TingkatanIqra::orderBy('level')->get();

        return view('livewire.admin.video.edit-video', [
            'tingkatans' => $tingkatans,
        ]);
    }
}
