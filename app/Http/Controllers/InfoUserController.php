<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InfoUserController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('laravel-examples.user-profile', compact('users'));
    }

    public function index()
    {
        $users = User::all();
        return view('laravel-examples.user-management', compact('users'));
    }

    public function store(Request $request) {        
        User::where('id',Auth::user()->id)
        ->update([
            'name'    => $request->name,
            'username' => $request->username,
        ]);
        return redirect('/user-profile')->with('success','Profile updated successfully');
    }

    public function addUser(Request $request) {
        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('user-management');
    }

    public function deleteUser($id) {
        $users = User::find($id);
        $users->delete();

        return redirect('user-management');
    }

    public function editUser(Request $request, $id) {
        $users = User::find($id);
        $users->update([
            'name' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        return redirect('user-management');
    }
}
