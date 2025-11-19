<?php
// app/Livewire/Admin/Video/DeleteVideo.php

namespace App\Livewire\Admin\Video;

use App\Models\VideoPembelajaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class DeleteVideo extends Component
{
    public VideoPembelajaran $video;
    public bool $confirmDelete = false;

    public function mount(VideoPembelajaran $video)
    {
        $this->video = $video;
    }

    public function confirmDeletion()
    {
        $this->resetErrorBag();
        $this->confirmDelete = true;
    }

    public function delete()
    {
        try {
            DB::beginTransaction();

            $judulVideo = $this->video->judul_video;

            // Hapus file video dari storage
            if ($this->video->video_path && Storage::disk('public')->exists($this->video->video_path)) {
                Storage::disk('public')->delete($this->video->video_path);
            }

            // Hapus file subtitle dari storage
            if ($this->video->subtitle_path && Storage::disk('public')->exists($this->video->subtitle_path)) {
                Storage::disk('public')->delete($this->video->subtitle_path);
            }

            // Hapus record dari database
            $this->video->delete();

            DB::commit();

            $this->dispatch('updated', [
                'title' => 'Video "' . $judulVideo . '" berhasil dihapus',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menghapus video: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmDelete = false;
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.admin.video.delete-video');
    }
}
