<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use ReCaptcha\ReCaptcha;

class RegisterController extends Controller
{
    /**
     * Display register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        // Verify reCAPTCHA
        $response = $this->verifyRecaptcha($request->input('g-recaptcha-response'), $request);
        if (!$response->isSuccess()) {
            return redirect()->back()->withErrors('reCAPTCHA verification failed.');
        }

        $user = User::create($request->validated());

        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }

    /**
     * Verify reCAPTCHA response
     *
     * @param string|null $response
     * @param Request $request
     * @return \ReCaptcha\Response
     */
    protected function verifyRecaptcha($response, $request)
    {
        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        return $recaptcha->verify($response, $request->ip());
    }
}
