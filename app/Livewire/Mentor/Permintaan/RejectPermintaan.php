<?php
// app/Livewire/Mentor/Permintaan/RejectPermintaan.php

namespace App\Livewire\Mentor\Permintaan;

use App\Models\PermintaanBimbingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RejectPermintaan extends Component
{
    public PermintaanBimbingan $permintaan;
    public bool $confirmReject = false;
    public $catatan = '';

    public function mount(PermintaanBimbingan $permintaan)
    {
        $this->permintaan = $permintaan;
    }

    public function confirmRejection()
    {
        // TEMPORARY DEBUG: Skip all validation
        $this->resetErrorBag();
        $this->confirmReject = true;
    }

    public function reject()
    {
        $this->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            // Double check authorization
            $mentor = Auth::user()->mentor;

            if ($this->permintaan->mentor_id != $mentor->mentor_id) {
                throw new \Exception('Anda tidak memiliki akses untuk menolak permintaan ini');
            }

            if ($this->permintaan->status != 'pending') {
                throw new \Exception('Permintaan sudah diproses sebelumnya');
            }

            DB::beginTransaction();

            $namamurid = $this->permintaan->murid->user->username ?? 'Murid';

            // Update status permintaan (TIDAK update mentor_id di murid)
            $this->permintaan->update([
                'status' => 'rejected',
                'tanggal_respons' => now(),
                'catatan' => $this->catatan ?: null,
            ]);

            DB::commit();

            $this->dispatch('updated', [
                'title' => 'Permintaan dari "' . $namamurid . '" telah ditolak',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menolak permintaan: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmReject = false;
        $this->catatan = '';
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.mentor.permintaan.reject-permintaan');
    }
}
