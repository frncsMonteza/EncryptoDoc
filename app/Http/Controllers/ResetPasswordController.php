<?php

namespace App\Http\Controllers;
// ResetPasswordController.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
        ? redirect()->route('home')->with(['success' => 'Your password has been reset successfully. You can now log in.'])
        : back()->withErrors(['email' => [__($status)]]);
    }
}
