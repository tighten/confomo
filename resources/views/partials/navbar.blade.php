<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#spark-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/img/confomo-logo.png') }}" alt="ConFOMO | Never miss out on new friends" height="55" />
            </a>
        </div>

        <div class="collapse navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if (App::environment('local') && Auth::guest())
                    <a href="/local-login" class="btn btn-default navbar-btn">
                        Login Magically
                    </a>
                @endif
                @if (Auth::guest())
                    <a href="/auth" class="btn btn-default navbar-btn">
                        <i class="fa fa-btn fa-twitter"></i>Login With Twitter
                    </a>
                @else
                    <span style="margin-right: 5px;">
                        <p class="navbar-text" class="margin-right: 10px;">{{ Auth::user()->name }}</p>
                    </span>

                    <a href="/auth/logout" class="btn btn-default navbar-btn">
                        <i class="fa fa-btn fa-sign-out"></i>Logout
                    </a>
                @endif
            </ul>
        </div>
    </div>
</nav>
