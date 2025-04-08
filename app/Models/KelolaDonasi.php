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
        'target_terkumpul'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($donasi) {
            if ($donasi->gambar) {
                Storage::disk('public')->delete($donasi->gambar);
            }
        });

        static::updating(function ($donasi) {
            if ($donasi->isDirty('gambar')) {
                $originalGambar = $donasi->getOriginal('gambar');
                if ($originalGambar) {
                    Storage::disk('public')->delete($originalGambar);
                }
            }
        });
    }
    
    /**
     * Format target_terkumpul ke Rupiah
     */
    public function getTargetTerkumpulFormattedAttribute()
    {
        return 'Rp ' . number_format($this->target_terkumpul, 0, ',', '.');
    }
}
