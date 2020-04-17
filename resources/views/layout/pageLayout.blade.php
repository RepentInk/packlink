<!DOCTYPE html>
<html>
  <head>

    @include('partials._pageStyle')

  </head>
  <body>

     @include('partials._pageHeader')

     <div id="app">

          @yield('section')

          @include('partials._pageFooter')

     </div>


    @include('partials._pageScript')

  </body>
</html>
