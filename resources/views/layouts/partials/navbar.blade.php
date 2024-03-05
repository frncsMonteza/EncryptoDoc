<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fa-solid fa-shield-halved fa-beat"></i> <b>EncryptoDoc</b>
        </a>
        @auth
        <div class="text-end">
            <span class="text-light me-3">{{ auth()->user()->username }}</span>
            <a href="{{ route('logout.perform') }}" class="btn btn-outline-light">Logout</a>
        </div>
        @endauth
    </div>
</nav>
