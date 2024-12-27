<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function index()
    {        
        $users = User::all();
        return new UserResource(true, 'List Data User', $users);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Mencari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Memeriksa apakah user ditemukan dan password sesuai
        if ($user && Hash::check($request->password, $user->password)) {
            // Mengecek apakah role user 1 atau 2
            if (in_array($user->role, [1, 2])) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak, hanya user dengan role 1 atau 2 yang dapat login!'
                ], 403); // 403 Forbidden
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah!'
            ], 401); // 401 Unauthorized
        }
    }


}
