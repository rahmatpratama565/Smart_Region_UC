<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;

class SecurityController extends Controller
{

public function index()
{

$logs = LoginLog::latest()->limit(100)->get();

return view('admin.security.index',compact('logs'));

}

}