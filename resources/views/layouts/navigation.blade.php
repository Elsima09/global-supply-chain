<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">
            Supply Chain AI
        </a>

        <div class="navbar-collapse d-flex justify-content-between w-100">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Countries</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Weather</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Currency</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">News</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Ports</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Comparison</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Watchlist</a>
                </li>

                @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admin</a>
                    </li>
                @endif
            </ul>

            <div class="d-flex align-items-center text-white gap-3">
                <span>{{ Auth::user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>