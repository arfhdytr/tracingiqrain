<?php

namespace App\Livewire\Admin\Approval;

use App\Models\Mentor;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RejectMentor extends Component
{
    public Mentor $mentor;
    public bool $confirmReject = false; 
    public string $reason = '';

    protected $rules = [
        'reason' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'reason.max' => 'Alasan tidak boleh lebih dari 500 karakter',
    ];

    public function mount(Mentor $mentor)
    {
        $this->mentor = $mentor;
    }

    public function confirmRejection()
    {
        $this->reason = ''; // Reset
        $this->resetErrorBag();
        $this->confirmReject = true;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function reject()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $this->mentor->update([
                'status_approval' => 'rejected',
                'alasan_tolak' => $this->reason ?: 'Tidak memenuhi persyaratan',
                'tgl_persetujuan' => null,
            ]);

            DB::commit();

            $this->dispatch('updated', [
                'title' => 'Mentor ' . $this->mentor->nama_lengkap . ' berhasil ditolak',
                'icon' => 'info',
                'iconColor' => 'blue',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('updated', [
                'title' => 'Gagal menolak mentor: ' . $e->getMessage(),
                'icon' => 'error',
                'iconColor' => 'red',
            ]);
        }

        $this->confirmReject = false;
        $this->dispatch('reloadTable');
    }

    public function render()
    {
        return view('livewire.admin.approval.reject-mentor');
    }
}
