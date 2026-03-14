<?php

namespace App\Exports;

use App\Models\DataWilayah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return DataWilayah::with('petugas')
            ->where('status_validasi','valid')
            ->get()
            ->map(function($d){

                return [
                    'Petugas' => $d->petugas->name,
                    'Wilayah' => $d->nama_wilayah,
                    'Jenis Data' => $d->jenis_data,
                    'Target' => $d->target,
                    'Realisasi' => $d->nilai_data,
                    'Progress' => round($d->progress).'%',
                    'Tanggal' => $d->tanggal_input
                ];

            });
    }


    public function headings(): array
    {
        return [
            'Petugas',
            'Wilayah',
            'Jenis Data',
            'Target',
            'Realisasi',
            'Progress',
            'Tanggal'
        ];
    }

}