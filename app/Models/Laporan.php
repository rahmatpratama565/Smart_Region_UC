<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{

    protected $table = 'laporan';

    protected $fillable = [
        'data_wilayah_id',
        'tanggal_laporan',
        'ringkasan_laporan'
    ];

    public function dataWilayah()
    {
        return $this->belongsTo(DataWilayah::class);
    }

}