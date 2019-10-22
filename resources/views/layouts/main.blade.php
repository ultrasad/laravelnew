<!DOCTYPE html>
<html>
  <head>
    @include('includes.head')
  </head>
  <body>
     {{-- @include('includes.sidebar') --}}

    <div class='container'>
      @yield('content')
    </div>

    @include('includes.foot')
 </body>
</html>
