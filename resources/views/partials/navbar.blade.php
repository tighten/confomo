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
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-default dropdown-toggle nav-action-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</button>
                    <ul class="dropdown-menu">
                        <li><a href="/settings">Settings</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    </ul>
                </div>
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
