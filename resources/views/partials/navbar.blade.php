<style>
    /* Temporary. I hate Bootstrap so badly. -MES */
    .nav-action-button {
        margin-top: 0.75em;
    }

    @media only screen and (min-width: 600px) {
        .nav-action-button {
            margin-top: 2em;
        }
    }
</style>
<nav class="navbar navbar-default">
    <div class="container">
        <div style="float: right; min-width: 200px; text-align: right;">
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
                <a href="/auth/logout" class="btn btn-default logout-button">
                    <i class="fa fa-btn fa-sign-out"></i>Logout {{ Auth::user()->name }}
                </a>
            @endif
        </div>

        <a href="/">
            <img src="{{ asset('assets/img/confomo-logo.png') }}" alt="ConFOMO | Never miss out on new friends" style="max-width: 45%;">
        </a>
    </div>
</nav>
