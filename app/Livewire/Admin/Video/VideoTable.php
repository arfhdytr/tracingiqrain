<?php
// app/Livewire/Admin/Video/VideoTable.php

namespace App\Livewire\Admin\Video;

use App\Models\VideoPembelajaran;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Support\Facades\Storage;

class VideoTable extends DataTableComponent
{
    protected $model = VideoPembelajaran::class;

    protected $listeners = ['reloadTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('video_id')
            ->setEmptyMessage('Tidak ada video yang ditemukan.')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setSearchEnabled()
            ->setSearchDebounce(500)
            ->setSearchPlaceholder('Cari video...');
    }

    public function builder(): Builder
    {
        return VideoPembelajaran::query()
            ->with('tingkatanIqra')
            ->select([
                'video_pembelajarans.video_id',
                'video_pembelajarans.tingkatan_id',
                'video_pembelajarans.judul_video',
                'video_pembelajarans.video_path',
                'video_pembelajarans.subtitle_path',
                'video_pembelajarans.deskripsi',
                'video_pembelajarans.created_at'
            ]);
    }

    public function columns(): array
    {
        return [
            Column::make('No', 'video_id')
                ->sortable()
                ->format(fn($v, $r, $c) => $c->getRowIndex() + 1),

            Column::make('Judul Video', 'judul_video')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return '<div class="flex flex-col">
                                <span class="font-medium text-gray-900 dark:text-white">' . $value . '</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-layer-group mr-1"></i>' . $row->tingkatanIqra->nama_tingkatan . '
                                </span>
                            </div>';
                })
                ->html(),

            Column::make('Tingkatan', 'tingkatanIqra.nama_tingkatan')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    $colors = [
                        1 => 'bg-red-100 text-red-800',
                        2 => 'bg-orange-100 text-orange-800',
                        3 => 'bg-yellow-100 text-yellow-800',
                        4 => 'bg-green-100 text-green-800',
                        5 => 'bg-blue-100 text-blue-800',
                        6 => 'bg-purple-100 text-purple-800',
                    ];
                    $colorClass = $colors[$row->tingkatanIqra->level] ?? 'bg-gray-100 text-gray-800';

                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $colorClass . '">
                                ' . $value . '
                            </span>';
                })
                ->html(),

            Column::make('Subtitle', 'subtitle_path')
                ->format(function ($value) {
                    if ($value && Storage::disk('public')->exists($value)) {
                        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-closed-captioning mr-1"></i> Ada
                                </span>';
                    }
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-times mr-1"></i> Tidak ada
                            </span>';
                })
                ->html(),

            Column::make('Ukuran File', 'video_path')
                ->format(function ($value) {
                    if ($value && Storage::disk('public')->exists($value)) {
                        $bytes = Storage::disk('public')->size($value);
                        $units = ['B', 'KB', 'MB', 'GB'];
                        $i = 0;
                        while ($bytes >= 1024 && $i < 3) {
                            $bytes /= 1024;
                            $i++;
                        }
                        return number_format($bytes, 2) . ' ' . $units[$i];
                    }
                    return '<span class="text-gray-400 italic">-</span>';
                })
                ->html(),

            Column::make('Ditambahkan', 'created_at')
                ->sortable()
                ->format(fn($v) => \Carbon\Carbon::parse($v)->format('d M Y')),

            Column::make('Aksi')
                ->label(function ($row) {
                    return view('components.column.video.actions', ['video' => $row]);
                })
                ->excludeFromColumnSelect(),
        ];
    }
}
