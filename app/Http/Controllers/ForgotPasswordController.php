<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.forgot-password');
    }

    /**
     * Process the forgot password form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email does not exist in our records.']);
        }
        
        // Send the password reset link to the user's email
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent successfully!')
            : back()->withErrors(['email' => 'Unable to send password reset link. Please try again later.']);
    }
}
