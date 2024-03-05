@extends('layouts.auth-master')

@section('content')
<div class="card card-sm bg-glass">
    <div class="card-header bg-transparent border-0">

        <div class="row justify-content-between align-items-center">

            <div class="col-auto">
                <a href="{{ route('login') }}" class="btn btn-link">&larr; Back</a>
            </div>
        </div>
    </div>

    <div class="card-body">
    <h4 class="mb-0"><b>Forgot Password</b></h4>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
            </div>
        </form>
    </div>
</div>
@endsection
