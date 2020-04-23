<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center" style="background-color:#EFF0F1">
        <a class="navbar-brand" href="{{ route('admin.index') }}">
            <img src="{{ asset('/image/packlink.png') }}" alt="" style="width:70px; height:65px;">
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center">

        <ul class="navbar-nav navbar-nav-right">


            <li class="nav-item dropdown d-xl-inline-block">

                <a class="nav-link dropdown-toggle" onclick="myFunction()" id="UserDropdown" href="#" data-toggle="dropdown"
                   aria-expanded="false">
                    @if(Auth::check())
                        <span class="profile-text">{{ Auth::user()->first_name }}</span>
                        <img class="img-xs rounded-circle" src="{{ asset(Auth::user()->profile) }}"
                             alt="Profile image">
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" id="menu" aria-labelledby="UserDropdown">

                    <a class="dropdown-item mt-2" href="" data-toggle="modal" data-target="#profile">
                        <i class="mdi mdi-account-circle" style="color: #1aff1b"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#changepass">
                        <i class="mdi  mdi-lock" style="color: #2173ff"></i>
                        Password
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}">
                        <i class="mdi mdi-power" style="color: #ff1216"></i>
                        Logout
                    </a>

                </div>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>

    </div>


</nav>

<admin-profile-component userinfo="{{ Auth::user() }}"></admin-profile-component>
