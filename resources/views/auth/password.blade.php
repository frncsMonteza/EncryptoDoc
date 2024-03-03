@extends('layouts.auth-master')

@section('content')
<div class="card card-sm pt-5 mt-5">
    <div class="card-body">
        <form method="post" action="{{ route('login.perform') }}" class="card-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <button>click me</button>

            @include('auth.partials.copy')
        </form>
    </div>

</div>
@endsection
