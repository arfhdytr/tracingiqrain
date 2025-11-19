<?php

namespace App\Livewire\Admin\Approval;

use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ApproveMentor extends Component
{
    public Mentor $mentor;
    public bool $confirmApprove = false; 

    public function mount(Mentor $mentor)
    {
        $this->mentor = $mentor;
    }

    // ✅ Method untuk buka modal
    public function confirmApproval()
    {
        $this->confirmApprove = true;
    }

    public function approve()
    {
        try {
            DB::beginTransaction();

            $this->mentor->update([
                'status_approval' => 'approved',
                'tgl_persetujuan' => now(),
                'alasan_tolak' => null,
            ]);

            DB::commit();

            // ✅ Gunakan dispatch untuk notifikasi
            $this->dispatch('updated', [
                'title' => 'Mentor ' . $this->mentor->nama_lengkap . ' berhasil disetujui!',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menyetujui mentor: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmApprove = false; // Tutup modal
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.admin.approval.approve-mentor');
    }
}
