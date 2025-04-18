<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormDonasi extends Model
{
    // Nama tabel secara eksplisit (sebenarnya bisa dihapus kalau namanya sesuai konvensi Laravel)
    protected $table = 'form_donasi';

    // Field yang boleh diisi melalui mass assignment
    protected $fillable = [
        'kelola_donasi_id', 'nama', 'nominal', 'kontak', 'pesan'
    ];

    // Relasi ke tabel kelola_donasi
    public function donasi()
    {
        return $this->belongsTo(KelolaDonasi::class, 'kelola_donasi_id');
    }
}
