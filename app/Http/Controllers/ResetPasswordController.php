<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function showResetPasswordForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        return view('auth.reset_password', ['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        // Check token
        $user = DB::table('user')
            ->where('EMAIL', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid token.']);
        }

        // Update password
        DB::table('user')
            ->where('EMAIL', $request->email)
            ->update(['PASSWORD' => Hash::make($request->password), 'token' => null]);

        return redirect('/login')->with('status', 'Your password has been reset!');
    }
}