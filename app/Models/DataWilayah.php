<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataWilayah extends Model
{

protected $table = 'data_wilayah';

protected $fillable = [

'user_id',
'nama_wilayah',

'latitude',
'longitude',

'jenis_data',
'target',
'nilai_data',
'progress',
'kendala',
'tanggal_input',
'foto_dokumentasi',
'status_validasi',
'validated_by'

];

protected $casts = [

'foto_dokumentasi' => 'array'

];

public function petugas()
{
return $this->belongsTo(User::class,'user_id');
}

public function validator()
{
return $this->belongsTo(User::class,'validated_by');
}

}