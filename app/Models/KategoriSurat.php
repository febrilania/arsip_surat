<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kategori', 'deskripsi'];
    protected $table = 'kategori_surat';

    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_surat_id');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'kategori_surat_id');
    }
}
