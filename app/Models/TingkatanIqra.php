<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatanIqra extends Model
{
    use HasFactory;

    protected $primaryKey = 'tingkatan_id';

    protected $fillable = [
        'level',
        'nama_tingkatan',
        'deskripsi',
    ];

    public function materiPembelajarans()
    {
        return $this->hasMany(MateriPembelajaran::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function videoPembelajarans()
    {
        return $this->hasMany(VideoPembelajaran::class, 'tingkatan_id', 'tingkatan_id');
    }

    public function jenisGames()
    {
        return $this->hasMany(JenisGame::class, 'tingkatan_id', 'tingkatan_id');
    }
}
