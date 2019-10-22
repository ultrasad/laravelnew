<!-- START HEADER -->
<header class="header">
  <!-- START MOBILE CONTROLS -->
  <div class="container-fluid relative">
    <!-- LEFT SIDE -->
    <div class="pull-left full-height visible-sm visible-xs">
      <!-- START ACTION BAR -->
      <div class="header-inner">
        <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block p-l-5 p-r-5" data-toggle="sidebar">
          <span class="icon-set menu-hambuger"></span>
        </a>
        <a href="#" class="search-link" data-toggle="search"><i class="pg-search"></i>search</a>
      </div>
      <!-- END ACTION BAR -->
    </div>
    <!--<div class="pull-center hidden-md hidden-lg">
      <div class="header-inner">
        <div class="brand inline">
          <div class="nav-logo nav-logo-center">
              <a title="WELOVEPRO | รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง" href="/">
                <img src="{{ URL::asset('assets/img/logo.png') }}" class="img-responsive" alt="รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง" data-src="{{ URL::asset('assets/img/logo.png') }}" data-src-retina="{{ URL::asset('assets/img/logo_2x.png') }}" width="70%" height="">
              </a>
          </div>
        </div>
      </div>
    </div>-->
    <!-- RIGHT SIDE -->
    <div class="pull-right full-height visible-sm visible-xs">
      <!-- START ACTION BAR -->
      <div class="header-inner">
        <a href="/events/create" class="btn-link visible-sm-inline-block visible-xs-inline-block">
          <span class="icon-set menu-hambuger-plus"></span>
        </a>
      </div>
      <!-- END ACTION BAR -->
    </div>

    <div class="pull-right full-height visible-sm visible-xs">
      <div class="header-inner">
        <ul class="nav-follow">
          <li><a target="_blank" href="http://www.facebook.com/WeLoveProFan" title="Follow us on Facebook" class="visible-sm-inline-block visible-xs-inline-block"><i class="fa fa-facebook-official fa-lg" aria-hidden="true"></i></a></li>
          <li><a target="_blank" href="http://twitter.com/welovepro" title="Follow us on Twitter" class="visible-sm-inline-block visible-xs-inline-block"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a></li>
          <li><a target="_blank" href="#" title="Follow us on Youtube" class="visible-sm-inline-block visible-xs-inline-block"><i class="fa fa-youtube-square fa-lg" aria-hidden="true"></i></a></li>
          <li><a href="/contact" title="Contact Us" class="visible-sm-inline-block visible-xs-inline-block"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
  <!-- END MOBILE CONTROLS -->
  <div class="pull-left sm-table hidden-xs hidden-sm">
    <div class="header-inner">
      <div class="brand inline">
        <a href="/" title="WELOVEPRO | รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง" class="clearfix"><img src="{{ URL::asset('assets/img/logo.png?v=1.0.0') }}" alt="รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง" data-src="{{ URL::asset('assets/img/logo.png?v=1.0.0') }}" data-src-retina="{{ URL::asset('assets/img/logo_2x.png?v=1.0.0') }}" width="" height="50"></a>
      </div>
      <a href="#" class="search-link" data-toggle="search"><i class="pg-search"></i>Type anywhere to search</a>
    </div>
  </div>

  @if (Auth::check())
    @if( Auth::User()->hasRole(['Administrator', 'Manager', 'Company Manager', 'User']))
    <div class=" pull-right">
      <div class="header-inner">
        <a href="/events/create" title="สร้างโปรโมชั่นใหม่" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs"></a>
      </div>
    </div>
    <div class=" pull-right">
      <!-- START User Info-->
        <div class="visible-lg visible-md m-t-10">
          <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
            <span class="semi-bold">{{ Auth::user()->name }}</span>
          </div>
          <div class="dropdown pull-right">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="thumbnail-wrapper d32 circular inline m-t-5">
                @if(!empty(Auth::user()->brand->first()->logo_image))
                  <img src="{{ URL::asset(Auth::user()->brand->first()->logo_image) }}" alt="" data-src="{{ URL::asset(Auth::user()->brand->first()->logo_image) }}" data-src-retina="{{ URL::asset(Auth::user()->brand->first()->logo_image) }}" width="32" height="32">
                @else
                  <img src="{{ URL::asset('images/brand/logo_20160628-102206-logo.png') }}" alt="" data-src="{{ URL::asset('images/brand/logo_20160628-102206-logo.png') }}" data-src-retina="{{ URL::asset('images/brand/logo_20160628-102206-logo.png') }}" width="32" height="32">
                @endif
              </span>
            </button>
            <ul class="dropdown-menu profile-dropdown" role="menu">
              <li><a href="/admin"><i class="pg-settings_small"></i> Manage</a>
              </li>
              <li><a href="#"><i class="pg-outdent"></i> Feedback</a>
              </li>
              <li><a href="#"><i class="pg-signals"></i> Help</a>
              </li>
              <li class="bg-master-lighter">
                <a href="/logout" class="clearfix">
                  <span class="pull-left">Logout</span>
                  <span class="pull-right"><i class="pg-power"></i></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      <!-- END User Info-->
    </div>
    @endif
  @else
  <div class=" pull-right">
    <div class="header-inner">
      <a href="/events/create" title="Member Login" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs"></a>
    </div>
  </div>
  @endif
  <div class="pull-right">
    <div class="header-inner">
      <ul class="nav-follow">
        <li><a target="_blank" href="http://www.facebook.com/WeLoveProFan" title="Follow us on Facebook" class="hidden-sm hidden-xs"><i class="fa fa-facebook-official fa-lg" aria-hidden="true"></i></a></li>
        <li><a target="_blank" href="http://twitter.com/welovepro" title="Follow us on Twitter" class="hidden-sm hidden-xs"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a></li>
        <li><a target="_blank" href="#" title="Follow us on Youtube" class="hidden-sm hidden-xs"><i class="fa fa-youtube-square fa-lg" aria-hidden="true"></i></a></li>
        <li><a href="/contact" title="Contact Us" class="hidden-sm hidden-xs"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></a></li>
      </ul>
    </div>
  </div>
</header>
<!-- END HEADER -->
