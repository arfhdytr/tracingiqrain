<?php
// app/Livewire/Admin/Mentor/MentorTable.php

namespace App\Livewire\Admin\Mentor;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MentorTable extends DataTableComponent
{
    protected $model = Mentor::class;

    protected $listeners = ['reloadTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('mentor_id')
            ->setDefaultSort('created_at', 'desc')
            ->setEmptyMessage('Tidak ada data mentor yang ditemukan.')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari mentor...')
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
            ->select([
                'mentors.mentor_id',
                'mentors.user_id',
                'mentors.nama_lengkap',
                'mentors.email',
                'mentors.no_wa',
                'mentors.status_approval',
                'mentors.tgl_persetujuan',
                'mentors.created_at'
            ])
            // Hanya tampilkan mentor yang sudah approved
            ->where('status_approval', 'approved');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'mentor_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Nama Lengkap', 'nama_lengkap')
                ->sortable()
                ->searchable(),

            Column::make('Username', 'user.username')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable()
                ->format(fn($v) => '<a href="mailto:' . $v . '" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">' . $v . '</a>')
                ->html(),

            Column::make('No. WhatsApp', 'no_wa')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    if ($value) {
                        return '<a href="https://wa.me/' . preg_replace('/[^0-9]/', '', $value) . '" target="_blank" class="inline-flex items-center text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                    <i class="fab fa-whatsapp mr-1"></i> ' . $value . '
                                </a>';
                    }
                    return '<span class="text-gray-400 italic">Tidak ada</span>';
                })
                ->html(),

            Column::make('Status', 'status_approval')
                ->sortable()
                ->format(function ($value) {
                    return match ($value) {
                        'approved' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                          <i class="fas fa-check-circle mr-1"></i> Disetujui
                                      </span>',
                        'pending' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                         <i class="fas fa-clock mr-1"></i> Pending
                                     </span>',
                        'rejected' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                          <i class="fas fa-times-circle mr-1"></i> Ditolak
                                      </span>',
                        default => '<span class="text-gray-400">-</span>'
                    };
                })
                ->html(),

            Column::make('Disetujui', 'tgl_persetujuan')
                ->sortable()
                ->format(fn($v) => $v ? \Carbon\Carbon::parse($v)->format('d M Y') : '<span class="text-gray-400 italic">-</span>')
                ->html(),

            Column::make('Terdaftar', 'created_at')
                ->sortable()
                ->format(fn($v) => \Carbon\Carbon::parse($v)->format('d M Y')),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.mentor.actions', ['mentor' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
