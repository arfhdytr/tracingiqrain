<?php
// app/Livewire/Admin/Tracking/TrackingTable.php

namespace App\Livewire\Admin\Tracking;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TrackingTable extends DataTableComponent
{
    protected $model = Murid::class;

    public function configure(): void
    {
        $this->setPrimaryKey('murid_id')
            ->setDefaultSort('created_at', 'desc')
            ->setEmptyMessage('Tidak ada data murid yang ditemukan.')
            ->setPerPageAccepted([5, 10, 25, 50])
            ->setPerPage(5)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari murid...');
    }

    public function builder(): Builder
    {
        return Murid::query()
            ->with(['user', 'leaderboards'])
            ->select([
                'murids.murid_id',
                'murids.user_id',
                'murids.mentor_id',
                'murids.sekolah',
                'murids.created_at'
            ])
            ->withCount('hasilGames')
            ->withCount('progressModuls');
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'murid_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Nama', 'user.username')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return '<div class="flex flex-col">
                                <span class="font-medium text-gray-900 dark:text-white">' . ($row->user->username ?? '-') . '</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-school mr-1"></i>' . ($row->sekolah ?: 'Tidak ada sekolah') . '
                                </span>
                            </div>';
                })
                ->html(),

            Column::make('Email', 'user.username')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    // Generate email dari username
                    $email = ($row->user->username ?? 'murid') . '@gmail.com';
                    return '<a href="mailto:' . $email . '" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">' . $email . '</a>';
                })
                ->html(),

            Column::make('Poin', 'murid_id')
                ->sortable()
                ->format(function ($value, $row) {
                    // Ambil total poin dari leaderboard global
                    $leaderboard = $row->leaderboards->where('mentor_id', null)->first();
                    $totalPoin = $leaderboard ? $leaderboard->total_poin_semua_game : 0;

                    return '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i>' . number_format($totalPoin) . ' poin
                            </span>';
                })
                ->html(),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.tracking.actions', ['murid' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
