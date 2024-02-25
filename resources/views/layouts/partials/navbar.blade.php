<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="fa-solid fa-shield-halved fa-beat"></i> <b>EncryptoDoc</b>
                </a>
                @auth
                {{auth()->user()->name}}
                    <div class="text-end">
                    <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
                    </div>
                @endauth
            </div>
        </nav>
