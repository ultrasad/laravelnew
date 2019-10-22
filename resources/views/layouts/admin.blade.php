<!DOCTYPE html>
<html>
  <head>
    @include('includes.head_admin')
  </head>
  <!-- <body class="fixed-header dashboard"> -->
  <body class="fixed-header menu-behind">
    @include('includes.sidebar_admin')
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
      @include('includes.header')
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <!-- <div class="content sm-gutter"> -->
        <div class="content">
          <!-- START ROW -->
          <div class="col-sm-12 text-center full-height form-process-overlay hide">
            <div class="progress-circle-indeterminate m-t-45" style="display: block;">
            </div>
            <br>
            <p class="small hint-text">Submit Processing...</p>
          </div>
          @yield('content')
          <!-- END ROW -->
        </div>
        <!-- END PAGE CONTENT -->
        @include('includes.footer')
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    <div class="quickview-wrapper maps" id="filters">
        <div class="quickview-list">
          <ul class="nav nav-tabs">
            <li class="">
                <a href="#"><i class="pg-map pull-left"></i><span class="map-location text-master"></span></a>
            </li>
          </ul>
          <a class="builder-close quickview-toggle pg-close" data-toggle="quickview" data-toggle-element="#filters" href="#"></a>
          <ul class="map-items" id="map-items">
            <!--
            <li class="map-event-list clearfix" style="display: none">
              <span class="col-xs-height col-top p-t-5">
                <span class="thumbnail-wrapper d32 circular bg-success">
                  <img width="34" height="34" class="col-top" src="assets/img/profiles/1.jpg" data-src="assets/img/profiles/1.jpg" data-src-retina="assets/img/profiles/1x.jpg" alt="">
                </span>
              </span>
              <div class="p-l-10 col-xs-height col-middle col-xs-12">
                <span class="text-master"><strong>ava flores</strong></span>
                <span class="block text-master hint-text fs-12">Hello there</span>
                <p>
                  <strong><a title="โปรฯ 7-11 เมษายน 2559 “แลกซื้อสุดคุ้ม” (26 มี.ค. – 25 เม.ย. 59)" href="/events/7-11-april-2016">โปรฯ 7-11 เมษายน 2559 “แลกซื้อสุดคุ้ม” (26 มี.ค. – 25 เม.ย. 59)</a></strong>
                </p>
              </div>
            </li>
            -->
          </ul>
        </div>
    </div>
    <!--START QUICKVIEW -->
    <!-- END QUICKVIEW-->
    <!-- START OVERLAY -->
    <div class="overlay hide" data-pages="search">
      <!-- BEGIN Overlay Content !-->
      <div class="overlay-content has-results m-t-20">
        <!-- BEGIN Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Logo !-->
          <img class="overlay-brand" src="{{ URL::asset('assets/img/logo.png') }}" alt="logo" data-src="{{ URL::asset('assets/img/logo.png') }}" data-src-retina="{{ URL::asset('assets/img/logo_2x.png') }}" width="78" height="22">
          <!-- END Overlay Logo !-->
          <!-- BEGIN Overlay Close !-->
          <a href="#" class="close-icon-light overlay-close text-black fs-16">
            <i class="pg-close"></i>
          </a>
          <!-- END Overlay Close !-->
        </div>
        <!-- END Overlay Header !-->
        <div class="container-fluid">
          <!-- BEGIN Overlay Controls !-->
          <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
          <br />
          <div class="inline-block">
            <i class="fa fa-search p-l-5" aria-hidden="true"></i><p class="inline-block fs-13 m-l-10">Press enter to search</p>
          </div>
          <!-- END Overlay Controls !-->
        </div>
        <!-- BEGIN Overlay Search Results, This part is for demo purpose, you can add anything you like !-->
        <div class="container-fluid">
          <div class="search-results m-t-20 p-b-50">
            <div class="search-header"><h4 class="bold hint-text result_pro" style="display: none"><u>Promotion Search Results</u></h4></div>
            <div class="full-height search-progress" style="display: none">
              <div class="panel-body text-center">
                <img alt="Progress" src="{{ URL::asset('assets/img/demo/progress.svg') }}" class="image-responsive-height demo-mw-50">
              </div>
            </div>
            <div class="row_result"></div>
            <p>&nbsp;</p>
            <div class="search-header"><h4 class="bold hint-text result_map" style="display: none"><u>Map Search Results</u></h4></div>
            <div class="row_result_map"></div>
          </div>
        </div>
        <div class="col_hidden_search">
          <div class="col-md-6 col-xs-12 col_result" style="display: none;">
            <div class="col-sm-12 p-l-0 p-r-0">
              <div class="col-md-1 col-sm-2 col-xs-3 padding-0">
                <div class="col-xs-12 thumbnail-wrapper bg-success text-white inline m-t-10 p-l-0 p-r-0">
                  <div class="search-img-thumb" style="background-image: url({{ URL::asset('assets/img/profiles/avatar.jpg') }});">>
                    <!--<img class="result-image" width="100%" height="60px" src="{{ URL::asset('assets/img/profiles/avatar.jpg') }}" data-src="{{ URL::asset('assets/img/profiles/avatar.jpg') }}" data-src-retina="{{ URL::asset('assets/img/profiles/avatar2x.jpg') }}" alt="">-->
                  </div>
                </div>
              </div>
              <div class="p-l-10 inline p-t-5 col-md-11 col-sm-10 col-xs-9 p-r-0">
                <a class="result-url" href="#" title=""><h5 class="m-b-5"><span class="semi-bold result-title">title</span></h5></a>
                <span class="result-brief">brief</span>
                <!--<p class="result-brand hint-text">via promotion</p>-->
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xs-12 col_result_map p-l-5" style="display: none">
            <div class="col-sm-12 p-l-0 p-r-0">
              <div class="p-l-10 inline p-t-5 col-md-12 p-r-0">
                <a class="result-url" href="#" title=""><h5 class="m-b-5"><i class="pg-map pull-left"></i>&nbsp;<span class="semi-bold result-title">title</span></h5></a>
              </div>
            </div>
          </div>
        </div>
        <!-- END Overlay Search Results !-->
      </div>
      <!-- END Overlay Content !-->
    </div>
    <!-- END OVERLAY -->

    @include('includes.foot_admin')
 </body>
</html>
