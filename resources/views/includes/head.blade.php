<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />

<meta content="@yield('og_url')" property="og:url">
<meta content="article" property="og:type">
<meta content="{{ env('FACEBOK_APP_KEY') }}" property="fb:app_id">
<meta content="@yield('og_title')" property="og:title">
<meta content="@yield('og_description')" name="description" />
<meta content="@yield('og_description')" property="og:description">
<meta content="@yield('og_description')" name="twitter:description">
<meta content="Welovepro" name="author" />
<meta content="@yield('og_image')" property="og:image">
<meta content="@yield('og_image')" name="twitter:image">
<meta content="Welovepro.com" property="og:site_name">
<meta content="@Welovepro" name="twitter:site">
<meta content="summary_large_image" name="twitter:card">
<meta content="th_TH" property="og:locale">

<title>@yield('page_title') | WELOVEPRO</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
<link rel="apple-touch-icon" href="pages/ico/60.png" />
<link rel="apple-touch-icon" sizes="76x76" href="{{ URL::asset('pages/ico/76.png') }}" />
<link rel="apple-touch-icon" sizes="120x120" href="{{ URL::asset('pages/ico/120.png') }}" />
<link rel="apple-touch-icon" sizes="152x152" href="{{ URL::asset('pages/ico/152.png') }}" />
<link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.ico') }}" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" type="text/css" media="screen" href="{{ elixir('css/all.css') }}" />
<!--<link rel="stylesheet" type="text/css" media="screen" href="{{ elixir('css/style.css') }}" />-->
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/css/style.css?v=1.0.0') }}" />
<!--[if lte IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="{{ URL::asset('assets/codrops-dialogFx/dialog.ie.css') }}" />
<![endif]-->
<script type="text/javascript">
var base_url = '{{ url('/') }}';
var app_id = '{{ env("FACEBOOK_APP_KEY") }}';
//console.log('app id => ' + app_id);
</script>
