@extends('layouts.auth-master')

@section('content')
<div class="card card-sm pt-5 mt-5">
    <div class="card-body">
        <form method="post" action="{{ route('login.perform') }}" class="card-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <!-- <img class="mb-4" src="{!! url('images/bootstrap-logo.svg') !!}" alt="" width="72" height="57"> -->
            <h1><b>EncryptoDoc</b></h1>

            <h1 class="h3 mb-3 fw-normal">Login</h1>

            @include('layouts.partials.messages')

            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
                <label for="floatingName">Email or Username</label>
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
            <!-- <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div> -->
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}

            <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

            <div class="text-center mt-3">
                <a href="">Forgot your password?</a> <!-- This is the added line -->
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('register.show') }}">Create an account</a>
            </div>

            @include('auth.partials.copy')
        </form>
    </div>

</div>
@endsection
