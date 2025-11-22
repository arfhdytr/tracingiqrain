<?php
// app/Livewire/Mentor/Murid/MuridTable.php

namespace App\Livewire\Mentor\Murid;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MuridTable extends DataTableComponent
{
    protected $model = Murid::class;

    protected $listeners = ['reloadTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('murid_id')
            ->setDefaultSort('created_at', 'desc')
            ->setEmptyMessage('Tidak ada murid yang ditemukan.')
            ->setPerPageAccepted([5, 10, 25, 50])
            ->setPerPage(5)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari murid...')
            -> setTableAttributes([
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
        $mentor = Auth::user()->mentor;

        return Murid::query()
            ->with('user')
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

            Column::make('Password', 'murid_id')
                ->format(fn() => '<span class="text-gray-500">••••••••</span>')
                ->html(),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.mentor.murid.actions', ['murid' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
