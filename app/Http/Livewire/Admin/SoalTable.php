<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class SoalTable extends DataTableComponent
{
    protected $model = SoalDragDrop::class;

    public function configure(): void
    {
        $this->setPrimaryKey('soal_id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setPerPageAccepted([10, 25, 50]);
        $this->setPerPage(10);
        $this->setSearchEnabled();
        $this->setColumnSelectEnabled();
        $this->setFilterLayoutSlideDown();
        $this->setLoadingPlaceholderEnabled();
        $this->setOfflineIndicatorEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'soal_id')
                ->sortable()
                ->searchable(),

            Column::make('Pertanyaan', 'pertanyaan')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value;
                }),

            Column::make('Tingkatan', 'tingkatanIqra.nama_tingkatan')
                ->sortable()
                ->searchable(),

            Column::make('Pembuat', 'mentor.nama_lengkap')
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value ?? '<span class="text-blue-600">Admin</span>';
                })
                ->html(),

            Column::make('Status', 'status_approval')
                ->sortable()
                ->format(function ($value) {
                    $badges = [
                        'pending' => '<span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>',
                        'approved' => '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Approved</span>',
                        'rejected' => '<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Rejected</span>',
                    ];
                    return $badges[$value] ?? $value;
                })
                ->html(),

            Column::make('Jawaban Benar', 'jawaban_benar')
                ->sortable(),

            Column::make('Dimainkan', 'hasil_games_count')
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 0;
                }),

            Column::make('Tanggal Dibuat', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d M Y');
                }),

            Column::make('Aksi')
                ->label(function ($row) {
                    $actions = '<div class="flex space-x-2">';

                    $actions .= '<button wire:click="view(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">View</button>';

                    if ($row->status_approval === 'pending') {
                        $actions .= '<button wire:click="approve(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">Approve</button>';
                        $actions .= '<button wire:click="reject(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Reject</button>';
                    }

                    $actions .= '<button wire:click="edit(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>';
                    $actions .= '<button wire:click="delete(' . $row->soal_id . ')" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Delete</button>';
                    $actions .= '</div>';

                    return $actions;
                })
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'Semua Status',
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('status_approval', $value);
                    }
                }),

            SelectFilter::make('Tingkatan')
                ->options([
                    '' => 'Semua Tingkatan',
                    '1' => 'Iqra 1',
                    '2' => 'Iqra 2',
                    '3' => 'Iqra 3',
                    '4' => 'Iqra 4',
                    '5' => 'Iqra 5',
                    '6' => 'Iqra 6',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value) {
                        $builder->where('tingkatan_id', $value);
                    }
                }),
        ];
    }

    public function builder(): Builder
    {
        return SoalDragDrop::query()
            ->with(['tingkatanIqra', 'mentor', 'admin'])
            ->withCount('hasilGames');
    }

    public function view($soalId)
    {
        $this->emit('viewSoal', $soalId);
    }

    public function approve($soalId)
    {
        $soal = SoalDragDrop::find($soalId);
        if ($soal) {
            $soal->update([
                'status_approval' => 'approved',
                'admin_id' => auth()->user()->admin->admin_id,
            ]);

            $this->emit('soalUpdated', 'Soal berhasil disetujui!');
        }
    }

    public function reject($soalId)
    {
        $soal = SoalDragDrop::find($soalId);
        if ($soal) {
            $soal->update([
                'status_approval' => 'rejected',
                'admin_id' => auth()->user()->admin->admin_id,
            ]);

            $this->emit('soalUpdated', 'Soal berhasil ditolak!');
        }
    }

    public function edit($soalId)
    {
        $this->emit('editSoal', $soalId);
    }

    public function delete($soalId)
    {
        $soal = SoalDragDrop::find($soalId);
        if ($soal) {
            $soal->delete();
            $this->emit('soalUpdated', 'Soal berhasil dihapus!');
        }
    }
}
