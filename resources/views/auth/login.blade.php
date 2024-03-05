@extends('layouts.auth-master')

@section('content')
<div class="card card-sm bg-glass">
    <div class="card-body">
        <form method="post" action="{{ route('login.perform') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
                <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required" id="password-field">
                <label for="floatingPassword">Password</label>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> <!-- Eye icon -->
                @if ($errors->has('password'))
                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                @endif
            </div>
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}

            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Login</button>
            <div class="text-center mt-3">
                <a href="{{ route('password.show') }}">Forgot password?</a>
            </div>
            <p class="small fw-bold mt-2 pt-1 mb-0 text-center">Don't have an account?
                <a href="{{ route('register.show') }}"class="link-primary">Register</a>
            </p>

            @include('auth.partials.copy')
        </form>
    </div>
</div>

<style>
    .field-icon {
        float: right;
        margin-right: 10px;
        margin-top: -35px;
        position: relative;
        z-index: 2;
    }

    .field-icon:hover {
        cursor: pointer;
    }
</style>

<!-- JavaScript for Eye Icon -->
<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
@endsection
