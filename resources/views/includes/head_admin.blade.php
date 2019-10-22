<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />

<meta content="@yield('og_url')" property="og:url">
<meta content="article" property="og:type">
<meta content="1532458647022405" property="fb:app_id">
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
<link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/img/favicon.ico') }}" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- <link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/pace/pace-theme-flash.css') }}" /> -->
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/jquery-scrollbar/jquery.scrollbar.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/bootstrap-select2/select2.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/jquery-metrojs/MetroJs.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/dropzone/css/dropzone.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/bootstrap-datepicker/css/datepicker3.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/bootstrap-tag/bootstrap-tagsinput.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/summernote/css/summernote.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/switchery/css/switchery.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/fotorama/fotorama.css') }}">
<!--<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/owl-carousel/assets/owl.carousel.css') }}"/>-->

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/jquery-datatable/media/css/dataTables.bootstrap.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatables-responsive/css/responsive.bootstrap.min.css') }}" />

<link rel="stylesheet" type="text/css" media="screen"  href="{{ URL::asset('assets/codrops-stepsform/css/component.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('pages/css/pages-icons.css') }}" />
<!--<link rel="stylesheet" type="text/css" href="{{ URL::asset('pages/css/themes/simple.css') }}" class="main-stylesheet" />-->

<link rel="stylesheet" type="text/css" href='https://fonts.googleapis.com/css?family=Kanit:400,500,700,200,100,100italic'>
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('pages/css/pages.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('assets/css/style.css?v=1.0.0') }}" />

<!--[if lte IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="{{ URL::asset('assets/codrops-dialogFx/dialog.ie.css') }}" />
<![endif]-->

<!--<script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>-->
<script type="text/javascript">
var base_url = '{{ url('/') }}';
var app_id = '{{ env("FACEBOOK_APP_KEY") }}';
console.log(app_id);
</script>
