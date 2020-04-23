<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <ul class="nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="menu-icon mdi mdi-television "></i>
                <span class="menu-title" style="font-size:18px">
                    Dashboard
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user') }}">
                <i class="menu-icon mdi mdi-account text-dark"></i>
                <span class="menu-title" style="font-size:16px">
                    Users
                </span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.category') }}">
                <i class="menu-icon mdi mdi-codepen text-warning"></i>
                <span class="menu-title" style="font-size:16px">
                    Category
                </span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.language') }}">
                <i class="menu-icon mdi mdi-cube text-secondary"></i>
                <span class="menu-title" style="font-size:16px">
                    Language
                </span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.installation') }}">
                <i class="menu-icon mdi mdi-book-open text-success"></i>
                <span class="menu-title"  style="font-size:16px">
                    Installation
                </span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.package') }}">
                <i class="menu-icon mdi mdi-archive text-primary"></i>
                <span class="menu-title"  style="font-size:16px">
                    Packages
                </span>
            </a>
        </li>

         {{--

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.message') }}">
                <i class="menu-icon mdi mdi-comment" style="color: #1aff1b"></i>
                <span class="menu-title"  style="font-size:16px">
                    Messages
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.donor') }}">
                <i class="menu-icon mdi mdi-account-star" style="color: #ff7221"></i>
                <span class="menu-title"  style="font-size:16px">
                    Donors
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.transaction') }}">
                <i class="menu-icon mdi mdi-cash" style="color: #a91dff"></i>
                <span class="menu-title"  style="font-size:16px">
                    Transaction
                </span>
            </a>
        </li>  --}}



        <li class="nav-item" style="margin-top: 30px"></li>

    </ul>

</nav>
