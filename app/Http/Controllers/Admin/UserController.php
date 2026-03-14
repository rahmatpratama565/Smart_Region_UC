<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

public function index()
{

$users = User::where('role','!=','admin')->get();

return view('admin.users.index',compact('users'));

}

public function create()
{

return view('admin.users.create');

}

public function store(Request $request)
{

User::create([

'name'=>$request->name,
'username'=>$request->username,
'email'=>$request->email,
'password'=>Hash::make($request->password),
'role'=>$request->role,
'status'=>'active'

]);

return redirect('/admin/users');

}

public function edit($id)
{

$user = User::find($id);

return view('admin.users.edit',compact('user'));

}

public function update(Request $request,$id)
{

$user = User::find($id);

$user->update([

'name'=>$request->name,
'username'=>$request->username,
'email'=>$request->email,
'role'=>$request->role

]);

return redirect('/admin/users');

}

public function toggleStatus($id)
{

$user = User::find($id);

if($user->status == 'active'){

$user->status = 'inactive';

}else{

$user->status = 'active';

}

$user->save();

return back();

}

public function destroy($id)
{

User::destroy($id);

return back();

}

}