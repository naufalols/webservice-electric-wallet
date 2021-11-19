<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            $token = $request->user()->createToken('login-client');
            return response()->json([
                'data' => $user,
                'token' => $token
            ]);
        }

        $result = array('email' => 'The provided credentials do not match our records.', );

        return json_encode($result);
    }
}
