<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $table = 'surat_masuk'; // Nama tabel di database

    protected $fillable = [
        'nomor_surat',
        'pengirim',
        'penerima',
        'perihal',
        'tanggal_surat',
        'tanggal_terima',
        'file_surat',
        'kategori_surat_id',
        'isi_ringkas',
        'status',
        'pembuat',
    ];

    protected $casts = [
        'pembuat' => 'integer',
    ];
    

    /**
     * Relasi ke tabel kategori_surats
     */
    public function kategoriSurat()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_surat_id');
    }

    /**
     * Relasi ke tabel users (pembuat surat)
     */
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'pembuat', 'id');
    }
}
