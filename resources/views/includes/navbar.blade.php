<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <h3 class="mb-0">My Portfolio</h3>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("guest.home") ? 'active' : '' }}" href="{{url('/') }}">{{ __('Home') }}</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") || request()->routeIs("admin.user_details.*") ? 'active' : '' }}" href="{{ route('admin.home') }}">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.projects.*") ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">{{ __('Projects') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.types.*") ? 'active' : '' }}" href="{{ route('admin.types.index') }}">{{ __('Project Types') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.technologies.*") ? 'active' : '' }}" href="{{ route('admin.technologies.index') }}">{{ __('Project Technologies') }}</a>
                </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <img class="img-fluid rounded-circle" style="width: 50px" src="{{ Auth::user()->userDetail?->profile_pic ? asset('storage/' . Auth::user()->userDetail->profile_pic)  : 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png' }}" alt="profile">
                <li class="nav-item dropdown d-flex align-items-center">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.home') }}">{{__('Dashboard')}}</a>
                        <a class="dropdown-item" href="{{ url('profile') }}">{{__('Profile')}}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>