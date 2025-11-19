<?php
// app/Livewire/Mentor/Permintaan/CancelPermintaan.php

namespace App\Livewire\Mentor\Permintaan;

use App\Models\PermintaanBimbingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CancelPermintaan extends Component
{
    public PermintaanBimbingan $permintaan;
    public bool $confirmCancel = false;

    public function mount(PermintaanBimbingan $permintaan)
    {
        $this->permintaan = $permintaan;
    }

    public function confirmCancellation()
    {
        // Pastikan permintaan adalah untuk mentor yang login
        $mentor = Auth::user()->mentor;

        if ($this->permintaan->mentor_id !== $mentor->mentor_id) {
            $this->dispatch('updated', [
                'title' => 'Anda tidak memiliki akses untuk membatalkan permintaan ini',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
            return;
        }

        // Pastikan status bukan pending
        if ($this->permintaan->status === 'pending') {
            $this->dispatch('updated', [
                'title' => 'Permintaan masih dalam status menunggu',
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
            return;
        }

        $this->resetErrorBag();
        $this->confirmCancel = true;
    }

    public function cancel()
    {
        try {
            // Double check authorization
            $mentor = Auth::user()->mentor;

            if ($this->permintaan->mentor_id !== $mentor->mentor_id || $this->permintaan->status === 'pending') {
                throw new \Exception('Unauthorized action');
            }

            DB::beginTransaction();

            $namamurid = $this->permintaan->murid->user->username ?? 'Murid';
            $statusLama = $this->permintaan->status;

            // Jika status sebelumnya approved, hapus mentor_id dari murid
            if ($statusLama === 'approved') {
                $this->permintaan->murid->update([
                    'mentor_id' => null,
                ]);
            }

            // Update status kembali ke pending
            $this->permintaan->update([
                'status' => 'pending',
                'tanggal_respons' => null,
                'catatan' => null,
            ]);

            DB::commit();

            $statusText = $statusLama === 'approved' ? 'penerimaan' : 'penolakan';

            $this->dispatch('updated', [
                'title' => ucfirst($statusText) . ' permintaan "' . $namamurid . '" berhasil dibatalkan',
                'icon' => 'success',
                'iconColor' => 'green',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal membatalkan: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmCancel = false;
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.mentor.permintaan.cancel-permintaan');
    }
}
