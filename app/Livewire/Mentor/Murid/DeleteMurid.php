<?php
// app/Livewire/Mentor/Murid/DeleteMurid.php

namespace App\Livewire\Mentor\Murid;

use App\Models\Murid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteMurid extends Component
{
    public Murid $murid;
    public bool $confirmDelete = false;

    public function mount(Murid $murid)
    {
        $this->murid = $murid;
    }

    public function confirmDeletion()
    {
        // Pastikan murid adalah murid binaan mentor yang login
        $mentor = Auth::user()->mentor;

        if ($this->murid->mentor_id !== $mentor->mentor_id) {
            $this->dispatch('updated', [
                'title' => 'Anda tidak memiliki akses untuk menghapus murid ini',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
            return;
        }

        $this->resetErrorBag();
        $this->confirmDelete = true;
    }

    public function delete()
    {
        try {
            // Double check authorization
            $mentor = Auth::user()->mentor;

            if ($this->murid->mentor_id !== $mentor->mentor_id) {
                throw new \Exception('Unauthorized action');
            }

            DB::beginTransaction();

            $username = $this->murid->user->username ?? 'Murid';

            // Hapus murid (cascade akan menghapus data terkait)
            $this->murid->delete();

            DB::commit();

            $this->dispatch('updated', [
                'title' => 'Murid "' . $username . '" berhasil dihapus',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menghapus murid: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmDelete = false;
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.mentor.murid.delete-murid');
    }
}
