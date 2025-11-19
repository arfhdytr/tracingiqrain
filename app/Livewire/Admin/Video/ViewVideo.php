<?php
// app/Livewire/Admin/Video/ViewVideo.php

namespace App\Livewire\Admin\Video;

use App\Models\VideoPembelajaran;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ViewVideo extends Component
{
    public VideoPembelajaran $video;

    public function mount(VideoPembelajaran $video)
    {
        $this->video = $video->load('tingkatanIqra');
    }

    public function getVideoUrlProperty()
    {
        if ($this->video->video_path && Storage::disk('public')->exists($this->video->video_path)) {
            return asset('storage/' . $this->video->video_path);
        }
        return null;
    }

    public function getSubtitleUrlProperty()
    {
        if ($this->video->subtitle_path && Storage::disk('public')->exists($this->video->subtitle_path)) {
            return asset('storage/' . $this->video->subtitle_path);
        }
        return null;
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

    public function downloadVideo()
    {
        if ($this->video->video_path && Storage::disk('public')->exists($this->video->video_path)) {
            return Storage::disk('public')->download($this->video->video_path, $this->video->judul_video . '.mp4');
        }
    }

    public function downloadSubtitle()
    {
        if ($this->video->subtitle_path && Storage::disk('public')->exists($this->video->subtitle_path)) {
            $extension = pathinfo($this->video->subtitle_path, PATHINFO_EXTENSION);
            return Storage::disk('public')->download($this->video->subtitle_path, $this->video->judul_video . '.' . $extension);
        }
    }

    public function render()
    {
        return view('livewire.admin.video.view-video');
    }
}
