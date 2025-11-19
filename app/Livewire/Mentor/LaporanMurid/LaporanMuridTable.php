<?php
// app/Livewire/Mentor/LaporanMurid/LaporanMuridTable.php

namespace App\Livewire\Mentor\LaporanMurid;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class LaporanMuridTable extends DataTableComponent
{
    protected $model = Murid::class;

    public function configure(): void
    {
        $this->setPrimaryKey('murid_id')
            ->setDefaultSort('created_at', 'desc')
            ->setEmptyMessage('Tidak ada murid yang ditemukan.')
            ->setPerPageAccepted([5, 10, 25, 50])
            ->setPerPage(5)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari murid...');
    }

    public function builder(): Builder
    {
        $mentor = Auth::user()->mentor;

        return Murid::query()
            ->with(['user', 'leaderboards'])
            ->where('mentor_id', $mentor->mentor_id)
            ->select([
                'murids.murid_id',
                'murids.user_id',
                'murids.mentor_id',
                'murids.sekolah',
                'murids.created_at'
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'murid_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Nama', 'user.username')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'user.username')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    $email = $value . '@gmail.com';
                    return '<a href="mailto:' . $email . '" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">' . $email . '</a>';
                })
                ->html(),

            Column::make('Poin', 'murid_id')
                ->sortable()
                ->format(function ($value, $row) {
                    // Ambil total poin dari leaderboard global
                    $leaderboard = $row->leaderboards->where('mentor_id', $row->mentor_id)->first();
                    $totalPoin = $leaderboard ? $leaderboard->total_poin_semua_game : 0;

                    return '<span class="text-gray-700 dark:text-gray-300 font-semibold">' . number_format($totalPoin) . ' poin</span>';
                })
                ->html(),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.mentor.laporan-murid.actions', ['murid' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
