<?php

namespace App\Exports;

use App\Models\UangDonasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UangDonasiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil data dari model UangDonasi
        return UangDonasi::select('nama_donasi', 'uang_masuk', 'uang_keluar', 'saldo')->get();
    }

    public function headings(): array
    {
        // Definisikan header kolom
        return [
            'Nama Donasi',
            'Uang Masuk',
            'Uang Keluar',
            'Sisa Saldo',
        ];
    }
}
