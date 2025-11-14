<?php
// app/Http/Livewire/Mentor/RejectModal.php

namespace App\Http\Livewire\Mentor\Approval;

use LivewireUI\Modal\ModalComponent;
use App\Models\Mentor;

class RejectModal extends ModalComponent
{
    public $mentorId;
    public $mentorName;
    public $alasan_tolak = '';

    protected $rules = [
        'alasan_tolak' => 'required|min:10'
    ];

    protected $messages = [
        'alasan_tolak.required' => 'Alasan penolakan harus diisi',
        'alasan_tolak.min' => 'Alasan penolakan minimal 10 karakter'
    ];

    public function mount($mentorId, $mentorName)
    {
        $this->mentorId = $mentorId;
        $this->mentorName = $mentorName;
    }

    public function reject()
    {
        $this->validate();

        try {
            $mentor = Mentor::findOrFail($this->mentorId);

            $mentor->update([
                'status_approval' => 'rejected',
                'tgl_persetujuan' => now(),
                'alasan_tolak' => $this->alasan_tolak
            ]);

            $this->emit('success', "Pendaftaran mentor {$this->mentorName} ditolak");
            $this->emit('refreshTable');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->emit('error', 'Gagal menolak mentor');
        }
    }

    public function render()
    {
        return view('livewire.mentor.reject-modal');
    }
}
