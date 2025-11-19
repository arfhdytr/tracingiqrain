<?php
// app/Livewire/Admin/Murid/DeleteMurid.php

namespace App\Livewire\Admin\Murid;

use App\Models\Murid;
use Illuminate\Support\Facades\DB;
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
        $this->resetErrorBag();
        $this->confirmDelete = true;
    }

    public function delete()
    {
        try {
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
        return view('livewire.admin.murid.delete-murid');
    }
}
