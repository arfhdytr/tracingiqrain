<?php
// app/Livewire/Mentor/Permintaan/ApprovePermintaan.php

namespace App\Livewire\Mentor\Permintaan;

use App\Models\PermintaanBimbingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        \Log::info('confirmApproval called', ['permintaan_id' => $this->permintaan->permintaan_id]);

        // Pastikan permintaan adalah untuk mentor yang login
        $mentor = Auth::user()->mentor;

        if ($this->permintaan->mentor_id !== $mentor->mentor_id) {
            \Log::warning('Authorization failed', ['expected' => $mentor->mentor_id, 'got' => $this->permintaan->mentor_id]);
            $this->dispatch('updated', [
                'title' => 'Anda tidak memiliki akses untuk menerima permintaan ini',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
            return;
        }

        // Pastikan status masih pending
        if ($this->permintaan->status !== 'pending') {
            \Log::warning('Status check failed', ['status' => $this->permintaan->status]);
            $this->dispatch('updated', [
                'title' => 'Permintaan sudah diproses sebelumnya',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
            return;
        }

        \Log::info('Setting confirmApprove to true');
        $this->resetErrorBag();
        $this->confirmApprove = true;
    }

    public function approve()
    {
        try {
            // Double check authorization
            $mentor = Auth::user()->mentor;

            if ($this->permintaan->mentor_id !== $mentor->mentor_id || $this->permintaan->status !== 'pending') {
                throw new \Exception('Unauthorized action');
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
