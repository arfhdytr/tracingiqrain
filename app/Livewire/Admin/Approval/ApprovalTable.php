<?php

namespace App\Livewire\Admin\Approval;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ApprovalTable extends DataTableComponent
{
    protected $model = Mentor::class;
    
    protected $listeners = ['reloadTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('mentor_id')
            ->setDefaultSort('created_at', 'desc')
            ->setEmptyMessage('Tidak ada data yang ditemukan.')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setTableAttributes([
                'class' => 'w-full',
            ])
            ->setTheadAttributes([
                'class' => 'bg-gray-50 dark:bg-gray-700',
            ])
            ->setThAttributes(function ($column) {
                return [
                    'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider',
                ];
            })
            ->setTdAttributes(
                function ($column, $row, $columnIndex, $rowIndex) {
                    return [
                        'class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100',
                    ];
                }
            );
    }

    public function builder(): Builder
    {
        return Mentor::query()
            ->with('user')
            ->where('status_approval', 'pending');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'mentor_id')
                ->sortable()
                ->format(
                    fn($v, $r, $c) => $c->getRowIndex() + $this->getPage() * $this->getPerPage() - ($this->getPerPage() - 1)
                ),
            Column::make('Nama', 'nama_lengkap')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Status Pendaftaran', 'created_at')
                ->sortable()
                ->format(fn($v) => 'Diminta ' . \Carbon\Carbon::parse($v)->diffForHumans()),
            Column::make('Aksi')
                ->label(function ($row) {
                    // Panggil view perantara
                    return view('components.column.approval.actions', ['mentor' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }

}
