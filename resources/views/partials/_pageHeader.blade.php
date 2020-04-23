<header class="header">

    <div class="bg-primary text-white py-2" style="background: linear-gradient(120deg,#EFF0F1, #EFF0F1);">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <ul class="list-inline mb-0">
                        @guest

                            <li class="list-inline-item" style="font-size:25px">
                                <a href="{{ route('index') }}">
                                    <img src="{{ asset('/image/packlink.png') }}" alt="" style="width:60px; height:50px;">
                                </a>
                            </li>

                        @endguest

                        @auth

                            <li class="list-inline-item" style="font-size:25px">
                                <a href="{{ route('dashboard') }}">
                                    <img src="{{ asset('/image/packlink.png') }}" alt="" style="width:60px; height:50px;">
                                </a>
                            </li>

                        @endauth


                    </ul>
                </div>

                <div class="col-lg-7 d-lg-block text-right">

                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            @guest

                                <a class="reset-anchor btn btn-sm btn-secondary" style="color:white" href="" data-toggle="modal" data-target="#loginModel">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span class="font-weight-normal text-small">
                                        Login
                                    </span>
                                </a>
                                <a class="reset-anchor btn btn-sm btn-primary" href="{{ route('signup') }}" style="color:white">
                                    <i class="fas fa-user-plus"></i>
                                    <span class="font-weight-normal text-small">
                                        Sign Up
                                    </span>
                                </a>

                            @endguest

                       @auth

                        @if(Auth::user()->user_type == 'admin')

                            <a class="reset-anchor btn btn-sm btn-secondary" style="color:white" href="" data-toggle="modal" data-target="#loginModel">
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="font-weight-normal text-small">
                                    Login
                                </span>
                            </a>

                        @endif

                        @if(Auth::user()->user_type == 'user')

                            <a class="dropdown" data-toggle="dropdown">
                                <img src="{{ asset(Auth::user()->profile) }}" alt="image" class="img dropdown-toggle" style="width:50px; height:50px; vertical-align: middle;border-radius: 50%;">
                                <div class="dropdown-menu">

                                    <a class="dropdown-item" href="#profileUser" data-toggle="modal" data-target="#profileUser">
                                        <i class="fas fa-user text-primary"></i>
                                        <span class="font-weight-normal text-small">
                                            Profile
                                        </span>
                                    </a>

                                    <a class="dropdown-item" href="#changeUserPass" data-toggle="modal" data-target="#changeUserPass">
                                        <i class="fas fa-lock text-success"></i>
                                        <span class="font-weight-normal text-small">
                                            Change Password
                                        </span>
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="fas fa-sign-out-alt text-danger"></i>
                                        <span class="font-weight-normal text-small">
                                            Logout
                                        </span>
                                    </a>


                                </div>
                            </a>

                        @endif

                        @endauth



                        </li>


                    </ul>


                </div>

            </div>
        </div>
    </div>


</header>



