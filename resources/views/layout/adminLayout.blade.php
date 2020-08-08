<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials.adminStyle')

</head>

<body>
<div class="container-scroller">


    <div id="app">


        @include('partials.adminNavbar')

        <div class="container-fluid page-body-wrapper">

            @include('partials.adminSidebar')

            <div class="main-panel">

                @yield('content')

                @include('partials.adminFooter')

            </div>

        </div>


    </div>



</div>

    @include('partials.adminScript')

</body>

</html>
