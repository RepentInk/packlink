<header class="header">

    <div class="bg-primary text-white py-2" style="background: linear-gradient(120deg,#FAFAFB, #FAFAFB);">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="https://www.facebook.com/bartendersguildghana" target="_blank">
                                <img src="{{ asset('image/facebook.png') }}" alt="facebook" width="30px"
                                     height="30px">
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/BARTENDERS_GH" target="_blank">
                                <img src="{{ asset('image/twitter.png') }}" alt="twitter" width="30px" height="30px">
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.instagram.com/bartendersguildghana" target="_blank">
                                <img src="{{ asset('image/instagram.png') }}" alt="twitter" width="30px" height="30px">
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-7 d-lg-block text-right">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="reset-anchor btn btn-secondary" href="#" style="color:white">
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="font-weight-normal text-small">
                                    Sign In
                                </span>
                            </a>
                            <a class="reset-anchor btn btn-primary" href="#" style="color:white">
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="font-weight-normal text-small">
                                    Sign Up
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{--  <nav class="navbar navbar-expand-lg navbar-light py-3 bg-white">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('index') }}" style="padding: 0; margin-bottom:-10px; margin-top:-10px">
                <img src="{{ asset('/logo.png') }}" alt="" style="width: 80px; height:80px; padding: 0">
            </a>

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link {{strtolower(Request::segment(1)) == ''?'active':''}}"
                           href="{{ route('index') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{strtolower(Request::segment(1)) == 'about'?'active':''}}"
                           href="{{route('about') }}">
                            About
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                       <a class="nav-link {{strtolower(Request::segment(1)) == 'program'?'active':''}}"
                          href="{{route('program') }}">
                           Program
                       </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{strtolower(Request::segment(1)) == 'donate'?'active':''}}"
                           href="{{ route('donate') }}">
                            Donate
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link {{strtolower(Request::segment(1)) == 'gallery'?'active':''}}"
                           href="{{ route('gallery') }}">
                            Gallery
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="" data-toggle="modal" data-target="#loginModel">
                            <i class="fas fa-sign-in-alt fa-fw" style="font-size:20px"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>  --}}

</header>

