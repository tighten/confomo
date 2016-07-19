<nav class="navbar navbar-default">
    <div class="container">
        <div class="nav-buttons">
            @if (App::environment('local') && Auth::guest())
                <a href="/local-login" class="btn btn-default nav-action-button">
                    Login Magically
                </a>
            @endif
            @if (Auth::guest())
                <a href="/auth" class="btn btn-default nav-action-button">
                    <i class="fa fa-btn fa-twitter"></i>Login With Twitter
                </a>
            @else
                <a href="/auth/logout" class="btn btn-default nav-action-button">
                    <i class="fa fa-btn fa-sign-out"></i>Logout {{ Auth::user()->name }}
                </a>
            @endif
        </div>

        <a href="/">
            <img
                src="{{ asset('assets/img/confomo-logo.png') }}"
                alt="ConFOMO | Never miss out on new friends"
                class="logo">
        </a>
    </div>
</nav>
