<?php
// app/Livewire/Admin/Mentor/DeleteMentor.php

namespace App\Livewire\Admin\Mentor;

use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DeleteMentor extends Component
{
    public Mentor $mentor;
    public bool $confirmDelete = false;

    public function mount(Mentor $mentor)
    {
        $this->mentor = $mentor;
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

            $namaLengkap = $this->mentor->nama_lengkap;
            $jumlahMurid = $this->mentor->murids()->count();

            // Hapus mentor (cascade akan menghapus data terkait)
            $this->mentor->delete();

            DB::commit();

            $message = 'Mentor "' . $namaLengkap . '" berhasil dihapus';
            if ($jumlahMurid > 0) {
                $message .= ' (' . $jumlahMurid . ' murid akan menjadi tanpa mentor)';
            }

            $this->dispatch('updated', [
                'title' => $message,
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menghapus mentor: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmDelete = false;
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.admin.mentor.delete-mentor');
    }
}
