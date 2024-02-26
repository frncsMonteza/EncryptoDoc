<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        // Verify reCAPTCHA
        $response = $this->verifyRecaptcha($request->input('g-recaptcha-response'), $request);
        if (!$response->isSuccess()) {
            return redirect()->back()->withErrors('reCAPTCHA verification failed.');
        }

        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) {
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
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
