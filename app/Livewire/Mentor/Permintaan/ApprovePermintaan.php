<?php
// app/Livewire/Mentor/Permintaan/ApprovePermintaan.php

namespace App\Livewire\Mentor\Permintaan;

use App\Models\PermintaanBimbingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ApprovePermintaan extends Component
{
    public PermintaanBimbingan $permintaan;
    public bool $confirmApprove = false;

    public function mount(PermintaanBimbingan $permintaan)
    {
        $this->permintaan = $permintaan;
    }

    public function confirmApproval()
    {
        // TEMPORARY DEBUG: Skip all validation
        $this->resetErrorBag();
        $this->confirmApprove = true;
    }

    public function approve()
    {
        try {
            // Double check authorization
            $mentor = Auth::user()->mentor;

            Log::info('Approve attempt', [
                'permintaan_mentor_id' => $this->permintaan->mentor_id,
                'logged_in_mentor_id' => $mentor->mentor_id,
                'permintaan_status' => $this->permintaan->status,
            ]);

            if ((int)$this->permintaan->mentor_id !== (int)$mentor->mentor_id) {
                throw new \Exception('Anda tidak memiliki akses untuk menerima permintaan ini');
            }

            if ($this->permintaan->status !== 'pending') {
                throw new \Exception('Permintaan sudah diproses sebelumnya');
            }

            DB::beginTransaction();

            $namamurid = $this->permintaan->murid->user->username ?? 'Murid';

            // Update status permintaan
            $this->permintaan->update([
                'status' => 'approved',
                'tanggal_respons' => now(),
            ]);

            // Update mentor_id pada murid
            $this->permintaan->murid->update([
                'mentor_id' => $mentor->mentor_id,
            ]);

            DB::commit();

            $this->dispatch('updated', [
                'title' => 'Permintaan dari "' . $namamurid . '" berhasil diterima!',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menerima permintaan: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmApprove = false;
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.mentor.permintaan.approve-permintaan');
    }
}
