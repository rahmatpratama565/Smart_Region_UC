<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
use HasFactory, Notifiable;

protected $table = 'users';

protected $fillable = [

'name',
'username',
'email',
'password',
'role',
'status'

];

protected $hidden = [

'password',
'remember_token',

];

protected $casts = [

'email_verified_at' => 'datetime',

];


// cek role admin
public function isAdmin()
{
return $this->role == 'admin';
}

// cek role petugas
public function isPetugas()
{
return $this->role == 'petugas';
}

// cek role pemimpin
public function isPemimpin()
{
return $this->role == 'pemimpin';
}


// relasi data wilayah dari petugas
public function dataWilayah()
{
return $this->hasMany(DataWilayah::class,'user_id');
}


// relasi validasi oleh admin
public function validasiData()
{
return $this->hasMany(DataWilayah::class,'validated_by');
}

}