<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{

protected $table = 'login_logs';

protected $fillable = [

'username',
'ip_address',
'status',
'user_agent',
'attempt_count',
'blocked'

];

protected $casts = [

'blocked' => 'boolean'

];

}