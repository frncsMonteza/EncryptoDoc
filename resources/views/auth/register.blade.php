@extends('layouts.auth-master')

@section('content')

<div class="card card-sm bg-glass">
    <div class="card-body">
        <form method="post" action="{{ route('register.perform') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <!-- <img class="mb-4" src="{!! url('images/bootstrap-logo.svg') !!}" alt="" width="72" height="57"> -->
            <h1><b>EncryptoDoc</b></h1>
            <h1 class="h3 mb-3 fw-normal">Register</h1>
            @include('layouts.partials.messages')
            <div class="form-group form-floating mb-3">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
                <label for="floatingEmail">Email address</label>
                @if ($errors->has('email'))
                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
                <label for="floatingName">Username</label>
                @if ($errors->has('username'))
                    <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                <label for="floatingPassword">Password</label>
                @if ($errors->has('password'))
                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
                <label for="floatingConfirmPassword">Confirm Password</label>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
            <!-- <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div> -->
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}
            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Register</button>
            <!-- <div class="text-center mt-3">
                <a href="{{ route('login') }}">Already have an account?</a>
            </div> -->
            <p class="small fw-bold mt-2 pt-1 mb-0 text-center">Already have an account?
                <a href="{{ route('login') }}"class="link-primary">Login</a>
            </p>
            @include('auth.partials.copy')
        </form>
    </div>
</div>

@endsection
