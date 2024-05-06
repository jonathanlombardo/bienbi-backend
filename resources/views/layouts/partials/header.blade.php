<header class="py-3 main_header text-white">
    <div class="container d-flex justify-content-between align-items-center">

        <span><img src="{{asset('img/logo_bienbi.png')}}" alt="Logo Bien-bì" class="logo_img"></span>
        <nav>
            <ul class="d-flex align-items-center gap-3">
            
                {{-- <button class="btn p-0">
                    <a class="nav_link" href="{{ route('guest.index') }}">Home</a>
                </button> --}}
                @guest
                    {{-- <button class="btn p-0">
                        <a class="nav_link" href="{{ route('login') }}">Login</a>
                    </button>
                    @if (Route::has('register'))
                        <button class="btn p-0">
                            <a class="nav_link" href="{{ route('register') }}">Register</a>
                        </button>
                    @endif --}}
                @else
                    <div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col d-flex justify-content-center align-items-center">

                                <button class="btn">
                                    <a class="nav-link nav_link" href="{{route('admin.services.index')}}">Services</a>
                                </button>
                                {{-- <button class="btn p-0">
                                    <a class="nav-link nav_link" href="{{route('admin.messages.index')}}">Messages</a>
                                </button> --}}
                                <button class="btn p-0">
                                    <a class="nav-link nav_link" href="{{route('admin.appartments.index')}}">I tuoi appartamenti</a>
                                </button>

                            </div>
                        </div>
                    </div>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle nav_link" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="navbarDropdown">
                            <div class="d-flex flex-column">
                                <a class="drop-item nav_link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                <a class="drop-item nav_link" href="{{ route('auth.profile.edit') }}">Profile</a>
                                <a class="drop-item nav_link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>
    </div>
</header>
