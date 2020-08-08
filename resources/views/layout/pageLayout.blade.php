<!DOCTYPE html>
<html>
  <head>

    @include('partials._pageStyle')

  </head>
  <body>

     @include('partials._pageHeader')

     <div id="app">

         {{--  //login component  --}}
          <login-component></login-component>

          <profile-component userinfo="{{ Auth::user() }}"></profile-component>

          @yield('section')

          @include('partials._pageFooter')

     </div>


    @include('partials._pageScript')

  </body>
</html>
