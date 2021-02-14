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
                    Categories
                </span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.language') }}">
                <i class="menu-icon mdi mdi-cube text-secondary"></i>
                <span class="menu-title" style="font-size:16px">
                    Languages
                </span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.installation') }}">
                <i class="menu-icon mdi mdi-book-open text-success"></i>
                <span class="menu-title"  style="font-size:16px">
                    Installations
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

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tutorial') }}">
                <i class="menu-icon mdi mdi-book" style="color: #1aff1b"></i>
                <span class="menu-title"  style="font-size:16px">
                    Tutorials
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.sponser') }}">
                <i class="menu-icon mdi mdi-account-star" style="color: #ff7221"></i>
                <span class="menu-title"  style="font-size:16px">
                    Sponsers
                </span>
            </a>
        </li>

        <li class="nav-item" style="margin-top: 30px"></li>

    </ul>

</nav>
