<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login method to authenticate users
    public function login(Request $request){
        $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus token akses yang sedang digunakan untuk permintaan ini
        $request->user()->currentAccessToken()->delete();

        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

}
