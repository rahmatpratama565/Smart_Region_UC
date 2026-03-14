<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {

        if (!Auth::check()) {

            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect('/admin/login');
            }

            if ($request->is('petugas') || $request->is('petugas/*')) {
                return redirect('/petugas/login');
            }

            if ($request->is('pemimpin') || $request->is('pemimpin/*')) {
                return redirect('/pemimpin/login');
            }

            return redirect('/admin/login');
        }

        /* CEK ROLE USER */

        $role = Auth::user()->role;

        if ($request->is('admin') && $role != 'admin') {
            return redirect('/'.$role);
        }

        if ($request->is('admin/*') && $role != 'admin') {
            return redirect('/'.$role);
        }

        if ($request->is('petugas') && $role != 'petugas') {
            return redirect('/'.$role);
        }

        if ($request->is('petugas/*') && $role != 'petugas') {
            return redirect('/'.$role);
        }

        if ($request->is('pemimpin') && $role != 'pemimpin') {
            return redirect('/'.$role);
        }

        if ($request->is('pemimpin/*') && $role != 'pemimpin') {
            return redirect('/'.$role);
        }

        return $next($request);
    }
}