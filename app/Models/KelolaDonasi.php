<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelolaDonasi extends Model
{
    use HasFactory;

    protected $table = 'kelola_donasi';

    protected $fillable = [
        'gambar',
        'nama',
        'deskripsi',
        'target_terkumpul',
        'donasi_terkumpul',
    ];

    /**
     * Boot method untuk menangani penghapusan dan update file gambar.
     */
    protected static function boot()
    {
        parent::boot();

        // Hapus gambar lama saat record dihapus
        static::deleting(function ($donasi) {
            if ($donasi->gambar) {
                Storage::disk('public')->delete($donasi->gambar);
            }
        });

        // Hapus gambar lama saat gambar di-update
        static::updating(function ($donasi) {
            if ($donasi->isDirty('gambar')) {
                $originalGambar = $donasi->getOriginal('gambar');
                if ($originalGambar) {
                    Storage::disk('public')->delete($originalGambar);
                }
            }
        });
    }

    // ✅ Ubah relasi ke UangDonasi
    public function uangDonasis()
    {
        return $this->hasMany(UangDonasi::class, 'kelola_donasi_id');
    }

    /**
     * Relasi ke form donasi.
     */
    public function formDonasis()
    {
        return $this->hasMany(FormDonasi::class, 'kelola_donasi_id');
    }

    /**
     * Format target_terkumpul ke format rupiah.
     */
    public function getTargetTerkumpulFormattedAttribute()
    {
        return 'Rp ' . number_format($this->target_terkumpul, 0, ',', '.');
    }

    /**
     * Format donasi_terkumpul ke format rupiah.
     */
    public function getDonasiTerkumpulFormattedAttribute()
    {
        return 'Rp ' . number_format($this->donasi_terkumpul, 0, ',', '.');
    }
}