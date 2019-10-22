<!DOCTYPE html>
<html>
  <head>
    @include('includes.head')
  </head>
  <!-- <body class="fixed-header dashboard"> -->
  <body class="fixed-header menu-behind">
	<div itemscope itemtype="http://schema.org/NewsArticle" id="container" class="hfeed">	
	<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
	<meta itemprop="url" content="@yield('og_url')" />
	<meta itemprop="description" content="@yield('og_description')" />
	<meta itemprop="articleSection" content="promotion" />
	<meta itemprop="articleSection" content="sale" />
	<meta itemprop="articleSection" content="โปรโมชั่น" />
	<meta itemprop="articleSection" content="ลดราคา" />
    @include('includes.sidebar')
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
      @include('includes.header')
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper {{ (Request::segment(1) == 'map')?'full-height':'' }}">
        <!-- START PAGE CONTENT -->
        <!-- <div class="content sm-gutter"> -->
        <!--<div class="content {{ (Request::segment(1) == 'map')?'full-width full-height overlay-footer':'' }}">-->
        <div class="content {{ (Request::segment(1) == 'map')?'full-width full-height overlay-footer':'' }}">
          <!-- START ROW -->
          @yield('content')
          <!-- END ROW -->
        </div>
        <!-- END PAGE CONTENT -->
        <!--
        @if(Request::segment(1) != 'map')
          @include('includes.footer')
        @endif
        -->
        @include('includes.footer')
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    <div class="quickview-wrapper maps" id="filters" style="display: ;">
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
          <a href="/" title="WELOVEPRO | รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง" class="clearfix"><img class="overlay-brand" src="{{ URL::asset('assets/img/logo.png?v=1.0.0') }}" alt="logo" data-src="{{ URL::asset('assets/img/logo.png?v=1.0.0') }}" data-src-retina="{{ URL::asset('assets/img/logo_2x.png?v=1.0.0') }}" width="" height="50"></a>
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
            <!--<p class="fs-13">
              <input type="radio" id="promotion" name="search_type" value="promotion" /> Promotion
              <input type="radio" id="brand" name="search_type" value="brand" /> Brand
            </p>-->
            <div class="radio radio-success">
              <input type="radio" id="type_promotion" name="searchtype" value="promotion" checked="checked">
              <label for="type_promotion">Promotion</label>
              <input type="radio" id="type_brand" name="searchtype" value="brand">
              <label for="type_brand">Brand</label>
            </div>
          </div>
          <div class="inline-block m-l-10">
            <i class="fa fa-search p-l-5" aria-hidden="true"></i><p class="inline-block fs-13 m-l-10">Press enter to search</p>
          </div>
          <!-- END Overlay Controls !-->
        </div>
        <!-- BEGIN Overlay Search Results, This part is for demo purpose, you can add anything you like !-->
        <div class="container-fluid">
          <div class="search-results m-t-20 p-b-50">
            <div class="search-header"><h4 class="bold hint-text result_brand" style="display: none"><u>Brand Search Results</u></h4></div>
            <div class="row_result_brand"></div>
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
            <p>&nbsp;</p>
          </div>
        </div>
        <div class="col_hidden_search">
          <div class="col-md-6 col-xs-12 col_result" style="display: none;">
            <div class="col-sm-12 p-l-0 p-r-0">
              <div class="col-md-1 col-sm-2 col-xs-3 padding-0">
                <div class="col-xs-12 thumbnail-wrapper bg-info text-white inline m-t-10 p-l-0 p-r-0">
                  <div class="search-img-thumb" style="background-image: url({{ URL::asset('assets/img/profiles/avatar.jpg') }});">
                    <!--<img class="result-image" width="100%" height="60px" src="{{ URL::asset('assets/img/profiles/avatar.jpg') }}" data-src="{{ URL::asset('assets/img/profiles/avatar.jpg') }}" data-src-retina="{{ URL::asset('assets/img/profiles/avatar2x.jpg') }}" alt="">-->
                  </div>
                </div>
              </div>
              <div class="p-l-10 inline p-t-5 col-md-11 col-sm-10 col-xs-9 p-r-0">
                <a class="result-url" href="#" title=""><h5 class="m-b-5"><span class="semi-bold result-title">โปรโมชั่น</span></h5></a>
                <span class="result-brief">รายละเอียดแบบย่อ</span>
                <!--<p class="result-brand hint-text">via promotion</p>-->
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xs-12 col_result_brand" style="display: none;">
            <div class="col-sm-12 p-l-0 p-r-0">
              <div class="col-md-1 col-sm-2 col-xs-3 padding-0">
                <div class="col-xs-12 thumbnail-wrapper bg-info text-white inline m-t-10 p-l-0 p-r-0">
                  <div class="search-img-thumb" style="background-image: url({{ URL::asset('assets/img/profiles/avatar.jpg') }});">
                    <!--<img class="result-image" width="100%" height="60px" src="{{ URL::asset('assets/img/profiles/avatar.jpg') }}" data-src="{{ URL::asset('assets/img/profiles/avatar.jpg') }}" data-src-retina="{{ URL::asset('assets/img/profiles/avatar2x.jpg') }}" alt="">-->
                  </div>
                </div>
              </div>
              <div class="p-l-10 inline p-t-5 col-md-11 col-sm-10 col-xs-9 p-r-0">
                <a class="result-url" href="#" title=""><h5 class="m-b-5"><span class="semi-bold result-name">แบรนด์</span></h5></a>
                <a class="result-category-url" href="#" title=""><span class="result-category">หมวดหมู่</span></a>
                <!--<p class="result-brand hint-text">via promotion</p>-->
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xs-12 col_result_map p-l-5" style="display: none">
            <div class="col-sm-12 p-l-0 p-r-0">
              <div class="p-l-10 inline p-t-5 col-md-12 p-r-0">
                <a class="result-url" href="#" title=""><h5 class="m-b-5"><i class="pg-map pull-left"></i>&nbsp;<span class="semi-bold result-title">โปรโมชั่น</span></h5></a>
              </div>
            </div>
          </div>
        </div>
        <!-- END Overlay Search Results !-->
      </div>
      <!-- END Overlay Content !-->
    </div>
    <!-- END OVERLAY -->

    <!-- Modal -->
    <!--<div id="map_canvas" class="map-canvas map-show" style="display: none"></div>-->
    <!--<div class="modal fade slide-up disable-scroll" id="modal_slideup_map" tabindex="-1" role="dialog" aria-hidden="false">-->
    <div class="modal fade slide-up disable-scroll" id="modal_map" tabindex="-1" role="dialog" aria-hidden="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
          <div class="modal-content">
            <div class="modal-header clearfix text-master text-left p-t-5 p-l-15 p-r-15">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
              <!--<h5>Payment <span class="semi-bold">Information</span></h5>-->
              <div class="item-header clearfix p-t-10">
                  <div class="thumbnail-wrapper d32 circular">
                    <img width="40" height="40" alt="Welovepro" data-src-retina="" data-src="" src="{{ URL::asset('assets/img/profiles/b2x.jpg') }}">
                  </div>
                  <div class="inline m-l-10">
                    <p class="no-margin">
                      <strong class="text-master"><a href="#" title="แบรนด์" class="brand-event-url">แบรนด์</a></strong>
                    </p>
                    <div class="hint-text small-text text-master"><a class="category-event-url" title="หมวดหมู่" href="#">หมวดหมู่</a></div>
                  </div>
              </div>
            </div>
            <div class="modal-body p-t-15">
              <div class="modal-branch text-master"><u><b><span class="brand">แบรนด์</span> สาขาที่ร่วมรายการ</b></u> <span class="brand_branch_list"></span></div>
            </div>
            <div class="modal-body">
              <div id="map_canvas_branch" class="map-canvas"></div>
              <input name="branch_location_lat" type="hidden" id="branch_location_lat" value="0" />
              <input name="branch_location_lon" type="hidden" id="branch_location_lon" value="0" />
              <input name="branch_location_zoom" type="hidden" id="branch_location_zoom" value="0" />

              <div class="row">
                <div class="col-sm-7">
                  <div class="p-t-20 clearfix p-l-10 p-r-10">
                    <div class="pull-left">
                      <p class="bold font-montserrat text-uppercase">&nbsp;</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-5 m-t-10 sm-m-t-10">
                  <div class="col-md-7 p-r-0"><button type="button" class="btn btn-primary btn-block m-t-5" id="btn-user-location">สาขาที่ใกล้คุณที่สุด</button></div>
                  <div class="col-md-5 p-r-5 p-l-10"><button type="button" data-dismiss="modal" class="btn btn-success btn-block m-t-5">ยกเลิก</button></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
    <!-- End Modal -->

    @include('includes.foot')
	</div>
 </body>
</html>
