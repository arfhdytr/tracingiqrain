<?php
// app/Livewire/Mentor/Permintaan/PermintaanTable.php

namespace App\Livewire\Mentor\Permintaan;

use App\Models\PermintaanBimbingan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class PermintaanTable extends DataTableComponent
{
    protected $model = PermintaanBimbingan::class;

    protected $listeners = ['reloadTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('permintaan_id')
            ->setEmptyMessage('Tidak ada permintaan bimbingan yang ditemukan.')
            ->setPerPageAccepted([5, 10, 25, 50])
            ->setPerPage(5)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari murid...')
            ->setFilterLayoutSlideDown();
    }

    public function builder(): Builder
    {
        $mentor = Auth::user()->mentor;

        return PermintaanBimbingan::query()
            ->with(['murid.user'])
            ->where('permintaan_bimbingans.mentor_id', $mentor->mentor_id)
            ->select([
                'permintaan_bimbingans.permintaan_id',
                'permintaan_bimbingans.murid_id',
                'permintaan_bimbingans.mentor_id',
                'permintaan_bimbingans.status',
                'permintaan_bimbingans.tanggal_permintaan',
                'permintaan_bimbingans.tanggal_respons',
                'permintaan_bimbingans.catatan',
            ]);
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua Status',
                    'pending' => 'Menunggu',
                    'approved' => 'Diterima',
                    'rejected' => 'Ditolak',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('status', $value);
                    }
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'permintaan_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Nama', 'murid.user.username')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'murid.user.username')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    $email = $value . '@gmail.com';
                    return '<a href="mailto:' . $email . '" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">' . $email . '</a>';
                })
                ->html(),

            Column::make('Status Permintaan', 'status')
                ->sortable()
                ->format(function ($value, $row) {
                    $badges = [
                        'pending' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu
                                    </span>',
                        'approved' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Diterima
                                    </span>',
                        'rejected' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>',
                    ];

                    $badge = $badges[$value] ?? '';
                    $waktu = '<div class="text-xs text-gray-500 dark:text-gray-400 mt-1">' . $row->waktu_permintaan . '</div>';

                    return $badge . $waktu;
                })
                ->html(),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.mentor.permintaan.actions', ['permintaan' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
