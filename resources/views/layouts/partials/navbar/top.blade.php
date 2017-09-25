<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @auth
                    <li>
                        <form class="hidden" id="logout-form" action="{{ route('logout') }}"
                              method="POST">
                            {{ csrf_field() }}
                        </form>
                        <a href="#"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{ route('welcome') }}">
                            Login
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>