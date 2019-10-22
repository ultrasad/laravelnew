<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8" />
  <title>เข้าสู่ระบบ | WELOVEPRO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
  <link rel="apple-touch-icon" href="pages/ico/60.png">
  <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
  <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
  <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
  <link rel="icon" type="image/x-icon" href="favicon.ico" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-touch-fullscreen" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" />

  <link rel="stylesheet" type="text/css" href='https://fonts.googleapis.com/css?family=Kanit:400,500,700,200,100,100italic'>
  <link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('pages/css/pages.css') }}" />
  <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('pages/css/style.css') }}" />

  {{--
  <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
  <link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
  <link href="assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
  <link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
  <link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
  <link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
  --}}

  <!--[if lte IE 9]>
      <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('pages/css/ie9.css') }}" />
  <![endif]-->
  <script type="text/javascript">
  <!-- // fix for windows 8 -->
  window.onload = function()
  {
    if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
      document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{{ URL::asset('pages/css/windows.chrome.fix.css') }}" />';
  }
  </script>
</head>
<body class="fixed-header ">
  <div class="login-wrapper ">
    @yield('content')
  </div>

  <!-- BEGIN VENDOR JS -->
  <script type="text/javascript" src="{{ URL::asset('assets/jquery/jquery-1.11.1.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('assets/jquery-validation/js/jquery.validate.min.js') }}"></script>
  {{--
  <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
  <script src="assets/plugins/modernizr.custom.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery-bez/jquery.bez.min.js"></script>
  <script src="assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery-actual/jquery.actual.min.js"></script>
  <script src="assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
  <script type="text/javascript" src="assets/plugins/bootstrap-select2/select2.min.js"></script>
  <script type="text/javascript" src="assets/plugins/classie/classie.js"></script>
  <script src="assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
  <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
  --}}
  <!-- END VENDOR JS -->
  <!-- <script src="pages/js/pages.min.js"></script> -->
  <script>
  $(function()
  {
    $('#form-login').validate()
  })
  </script>
</body>
{{--
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</body>
--}}
</html>
