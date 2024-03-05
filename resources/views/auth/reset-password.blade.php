@extends('layouts.auth-master')

@section('content')
<div class="card card-sm bg-glass">
    <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">Reset Password</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
