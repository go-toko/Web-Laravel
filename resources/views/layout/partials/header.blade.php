@if (Auth::user() != null)
    <!-- Header -->
    @if (
        !Route::is([
            'example-page.index-one',
            'example-page.index-two',
            'example-page.index-three',
            'example-page.index-four',
        ]))
        <div class="header">
    @endif
    @if (Route::is(['example-page.index-one']))
        <div class="header header-one">
    @endif
    @if (Route::is(['example-page.index-two']))
        <div class="header header-two">
    @endif
    @if (Route::is(['example-page.index-three']))
        <div class="header header-three">
    @endif
    @if (Route::is(['example-page.index-four']))
        <div class="header header-four">
    @endif
    @if (Route::is(['example-page.index-two', 'example-page.index-three']))
        <div class="container">
    @endif
    <!-- Logo -->
    <div class="header-left active">
        <a href="{{ route('login') }}" class="logo logo-normal">
            <img src="{{ URL::asset('/assets/img/Pos-gotoko-colorfull.png') }}" alt="">
        </a>
        <a href="{{ route('login') }}" class="logo logo-white">
            <img src="{{ URL::asset('assets/img/Pos-gotoko-white.png') }}" alt="">
        </a>
        <a href="{{ route('login') }}" class="logo-small">
            <img src="{{ URL::asset('/assets/img/logo-small.png') }}" alt="">
        </a>
        @if (!Route::is(['example-page.index-one', 'example-page.index-three', 'example-page.index-four']))
            <a id="toggle_btn" href="javascript:void(0);">
            </a>
        @endif

    </div>
    <!-- /Logo -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    @if (Route::is(['example-page.index-two']))
        <div class="top-nav-search">

            <a href="javascript:void(0);" class="responsive-search">
                <i class="fa fa-search"></i>
            </a>
            <form action="#">
                <div class="searchinputs">
                    <input type="text" placeholder="Search Here ...">
                    <div class="search-addon">
                        <span><img src="{{ URL::asset('assets/img/icons/closes.svg') }}" alt="img"></span>
                    </div>
                </div>
                <a class="btn" id="searchdiv"><img src="{{ URL::asset('assets/img/icons/search.svg') }}"
                        alt="img"></a>
            </form>
        </div>
    @endif

    <ul class="nav user-menu">
        @if (!Route::is(['example-page.index-two']))
            <li class="nav-item my-auto">
                @if (Auth::user()->isSubscribe == 0)
                    <i class="fas fa-gift fa-lg"></i>
                    <span class="badge rounded-pill bg-primary">
                        Freemium
                    </span>
                @else
                    <i class="fas fa-crown"></i>
                    <span class="badge rouded-pill bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->subscription->expire)) }} days left">
                        Premium
                    </span>
                    <span class="badge rounded-pill bg-danger">
                        {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->subscription->expire)) }}
                        days left
                    </span>
                @endif
            </li>
        @endif

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-img"><img src="{{ Auth::user()->userProfile->picture }}" alt="">
                    <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ Auth::user()->userProfile->picture }}" alt="">
                        </span>
                        <div class="profilesets">
                            <h6>{{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}
                            </h6>
                            <h5>{{ Auth::user()->role->name }}</h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="{{ route('my-profile.index') }}"> <i class="me-2"
                            data-feather="user"></i> My Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item logout pb-0"><img
                                src="{{ URL::asset('/assets/img/icons/log-out.svg') }}" class="me-2"
                                alt="img">Logout</button>
                    </form>
                </div>
            </div>
        </li>
    </ul>

    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('my-profile.index') }}">My Profile</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item d-flex flex-row align-items-center"
                    style="max-height: 40px;" <img src="{{ URL::asset('/assets/img/icons/log-out.svg') }}"
                    class="me-2" alt="img">Logout</button>
            </form>
        </div>
    </div>
    <!-- /Mobile Menu -->
    @if (Route::is(['example-page.index-three']))
        </div>
    @endif
    </div>

    <!-- Header -->
@endif
