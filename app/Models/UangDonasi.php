<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UangDonasi extends Model
{
    protected $table = 'uang_donasi';
    protected $fillable = [
        'nama_donasi',
        'uang_masuk',
        'uang_keluar',
        'saldo',
    ];

    //Relation to KelolaDonasi
    // public function kelolaDonasi()
    // {
    //     return $this->belongsTo(KelolaDonasi::class);
    // }

    // Mutator untuk menghitung saldo secara otomatis
    public function setSaldoAttribute()
    {
        $this->attributes['saldo'] = $this->attributes['uang_masuk'] - $this->attributes['uang_keluar'];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->saldo = $model->uang_masuk - $model->uang_keluar;
        });
    }

    // Formatter untuk uang masuk
    public function getUangMasukFormattedAttribute()
    {
        return 'Rp ' . number_format($this->uang_masuk, 0, ',', '.');
    }

    // Formatter untuk uang keluar
    public function getUangKeluarFormattedAttribute()
    {
        return 'Rp ' . number_format($this->uang_keluar, 0, ',', '.');
    }

    // Formatter untuk saldo
    public function getSaldoFormattedAttribute()
    {
        return 'Rp ' . number_format($this->saldo, 0, ',', '.');
    }
}
