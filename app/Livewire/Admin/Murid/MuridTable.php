<?php
// app/Livewire/Admin/Murid/MuridTable.php

namespace App\Livewire\Admin\Murid;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Builder;
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
            ->setEmptyMessage('Tidak ada data murid yang ditemukan.')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari murid...');
    }

    public function builder(): Builder
    {
        return Murid::query()
            ->with(['user', 'mentor.user'])
            ->select([
                'murids.murid_id',       
                'murids.user_id',        
                'murids.mentor_id',      
                'murids.sekolah',        
                'murids.preferensi_terisi',
                'murids.created_at'      
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'murid_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Username', 'user.username')
                ->sortable()
                ->searchable(),

            Column::make('Sekolah', 'sekolah')
                ->sortable()
                ->searchable()
                ->format(fn($v) => $v ?: '<span class="text-gray-400 italic">Belum diisi</span>')
                ->html(),

            Column::make('Mentor', 'mentor.nama_lengkap')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    if ($row->mentor) {
                        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-user-tie mr-1"></i> ' . $row->mentor->nama_lengkap . '
                                </span>';
                    }
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-user-slash mr-1"></i> Tidak ada mentor
                            </span>';
                })
                ->html(),

            Column::make('Preferensi', 'preferensi_terisi')
                ->sortable()
                ->format(function ($value) {
                    if ($value) {
                        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Sudah
                                </span>';
                    }
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-exclamation-circle mr-1"></i> Belum
                            </span>';
                })
                ->html(),

            Column::make('Terdaftar', 'created_at')
                ->sortable()
                ->format(fn($v) => \Carbon\Carbon::parse($v)->format('d M Y')),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.murid.actions', ['murid' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
