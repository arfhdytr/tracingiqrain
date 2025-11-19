<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBimbingan extends Model
{
    use HasFactory;

    protected $primaryKey = 'permintaan_id';

    protected $fillable = [
        'murid_id',
        'mentor_id',
        'status',
        'tanggal_permintaan',
        'tanggal_respons',
        'catatan',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'datetime',
        'tanggal_respons' => 'datetime',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id', 'murid_id');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }

    // Helper method untuk format waktu
    public function getWaktuPermintaanAttribute()
    {
        if (!$this->tanggal_permintaan) {
            return '-';
        }

        // Carbon akan secara otomatis menentukan 'baru saja', 'jam', 'hari', 'kemarin', dll.
        return 'Diminta ' . $this->tanggal_permintaan->diffForHumans();
    }

    public function getStatusBadgeAttribute()
    {
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

        return $badges[$this->status] ?? '';
    }

    // Scope untuk pending requests
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
