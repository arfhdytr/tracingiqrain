<?php

namespace App\Livewire\Admin\Approval;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ApprovalTable extends DataTableComponent
{
    public bool $columnSelect = false;

    // Modal properties
    public $isRejectModalOpen = false;
    public $selectedMentorId;
    public $selectedMentorName;
    public $alasan_tolak = '';

    protected $listeners = ['refreshTable' => '$refresh'];

    // Builder method (Wajib)
    public function builder(): Builder
    {
        return Mentor::query()
            ->with('user')
            ->when(
                $this->getFilter('status'),
                fn($query, $status) =>
                $query->where('status_approval', $status)
            )
            ->when(
                !$this->getFilter('status'),
                fn($query) =>
                $query->where('status_approval', 'pending')
            );
    }

    public function configure(): void
    {
        $this->setPrimaryKey('mentor_id');
        $this->setPerPageAccepted([5, 10, 25, 50]);
        $this->setPerPage(5);
        $this->setSearchPlaceholder('Cari Mentor');
    }

    public function columns(): array
    {
        return [
            Column::make('No')
                ->sortable()
                ->format(function ($value, $column, $row) {
                    static $index = 0;
                    return ++$index;
                })
                ->excludeFromColumnSelect(),

            Column::make('Nama', 'nama_lengkap')
                ->sortable()
                ->searchable()
                ->excludeFromColumnSelect(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Status Pendaftaran', 'created_at')
                ->sortable()
                ->format(function ($value, $column, $row) {
                    $days = now()->diffInDays($row->created_at);
                    $hours = now()->diffInHours($row->created_at);

                    if ($days > 0) {
                        return "Diminta {$days} hari yang lalu";
                    } elseif ($hours > 0) {
                        return "Diminta {$hours} jam yang lalu";
                    } else {
                        return "Diminta baru saja";
                    }
                }),

            Column::make('Aksi')
                ->format(function ($value, $column, $row) {
                    return view('components.column.mentor-approval-action', ['row' => $row]);
                }),
        ];
    }

    public function filters(): array
    {
        return [
            'status' => SelectFilter::make('Status')
                ->options([
                    '' => 'Semua',
                    'pending' => 'Menunggu',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak'
                ]),
        ];
    }

    /**
     * resetModal
     *
     * @return void
     */
    private function resetModal()
    {
        $this->reset('selectedMentorId', 'selectedMentorName', 'alasan_tolak');
    }

    /**
     * openRejectModal
     *
     * @return void
     */
    public function openRejectModal($mentorId, $mentorName)
    {
        $this->selectedMentorId = $mentorId;
        $this->selectedMentorName = $mentorName;
        $this->isRejectModalOpen = true;
    }

    /**
     * closeRejectModal
     *
     * @return void
     */
    public function closeRejectModal()
    {
        $this->isRejectModalOpen = false;
        $this->resetModal();
    }

    /**
     * approve
     *
     * Method untuk approve mentor
     *
     * @return void
     */
    public function approve($mentorId)
    {
        try {
            $mentor = Mentor::findOrFail($mentorId);

            $mentor->update([
                'status_approval' => 'approved',
                'tgl_persetujuan' => now(),
                'alasan_tolak' => null
            ]);

            $this->emit('success', "Mentor {$mentor->nama_lengkap} berhasil disetujui");
        } catch (\Exception $e) {
            $this->emit('error', 'Gagal menyetujui mentor: ' . $e->getMessage());
        }
    }

    /**
     * reject
     *
     * Method untuk reject mentor
     *
     * @return void
     */
    public function reject()
    {
        $this->validate([
            'alasan_tolak' => 'required|min:10'
        ], [
            'alasan_tolak.required' => 'Alasan penolakan harus diisi',
            'alasan_tolak.min' => 'Alasan penolakan minimal 10 karakter'
        ]);

        try {
            $mentor = Mentor::findOrFail($this->selectedMentorId);

            $mentor->update([
                'status_approval' => 'rejected',
                'tgl_persetujuan' => now(),
                'alasan_tolak' => $this->alasan_tolak
            ]);

            $this->closeRejectModal();
            $this->emit('success', "Pendaftaran mentor {$this->selectedMentorName} ditolak");
        } catch (\Exception $e) {
            $this->emit('error', 'Gagal menolak mentor: ' . $e->getMessage());
        }
    }
}
