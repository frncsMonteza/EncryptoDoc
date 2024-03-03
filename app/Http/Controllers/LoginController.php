<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha; // Assuming you want to keep this import

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
        // Validate reCAPTCHA
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['captcha' => 'Please complete the reCAPTCHA.']);
        }

        $credentials = $request->getCredentials();

        if (!Auth::attempt($credentials)) {
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        }

        $user = Auth::user();

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
}
