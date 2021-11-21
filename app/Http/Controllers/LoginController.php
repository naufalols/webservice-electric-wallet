<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    use HasApiTokens;
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user   = auth()->user();
            $token  = $request->user()->createToken('login-client');
            return response()->json([
                'data'  => $user,
                'token' => $token
            ], 200);
        }

        $data['status'] = 401;
        $data['message'] = 'Unauthorized';

        return response()->json($data, 401);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        
        $data['status'] = 200;
        $data['message'] = 'logout successfully';

        return response()->json($data, 200);
    }
}
