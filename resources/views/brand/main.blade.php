@extends('layouts.document')
@section('page_title', 'แบรนด์ทั้งหมด')
@section('content')

<!-- START JUMBOTRON -->
<div class="jumbotron m-b-20" data-pages="parallax">
  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="inner">
      <!-- START BREADCRUMB -->
      <ul class="breadcrumb">
        <li>
          <a href="/" title="หน้าแรก"><i class="fa fa-home" aria-hidden="true"></i></a>
        </li>
        <li><span class="p-l-5 m-l-5 fs-12">แบรนด์ทั้งหมด</span></li>
      </ul>
      <!-- END BREADCRUMB -->
    </div>
  </div>
</div>
<!-- END JUMBOTRON -->

<div class="social-wrapper">
  <div class="social-element" data-pages="social">
    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
      <div class="m-b-5">&nbsp;</div>

      @if($brands->count() < 1)
      <div class="p-l-0 col-md-12 promotion-empty text-master">ยังไม่มีแบรนด์ ในขณะนี้...</div>
      @endif
      <div class="feed">
        <!-- START DAY -->
        <div class="day" data-social="day">
          <!-- START ITEM -->
          <!--<div class="card col2-element col-centered" data-social="item">
            <div class="gallery-item" data-width="2" data-height="2">
              <div class="live-tile slide" data-speed="750" data-delay="4000" data-mode="carousel">
                <div class="slide-front">
                  <img src="{{ GlideImage::load('/images/events/2016-03-30/gallery/43/20160330-141855-Promotion-Reebok-Grand-Sale-2016-Sale-up-to-70-Off.png')->modify(['w'=> 640, 'fm'=>'jpg']) }}" class="img-responsive" />
                </div>
                <div class="slide-back">
                  <img src="{{ GlideImage::load('/images/events/2016-03-30/20160330-120609-Promotion-Crocs-End-Of-Season-Sale-up-to-50-Mar.2016.jpg')->modify(['w'=> 640, 'fm'=>'jpg']) }}" class="img-responsive" />
                </div>
              </div>
              <div class="overlayer bottom-left full-width">
                <div class="overlayer-wrapper item-info more-content">
                  <div class="gradient-grey p-l-20 p-r-20 p-t-50 p-b-5">
                    <div class="">
                      <h3 class="pull-left bold text-white no-margin">โปรโมชั่น Sports Revolution Warehouse Sale ครั้งที่4 Nike, Under Armour, ASICS, Crocs Sale ลดสูงสุด 80%</h3>
                      <div class="clearfix"></div>
                    </div>
                    <div class="m-t-20">
                      <div class="thumbnail-wrapper d32 circular m-t-5">
                        <img width="40" height="40" src="/assets/img/profiles/avatar.jpg" data-src="/assets/img/profiles/avatar.jpg" data-src-retina="/assets/img/profiles/avatar2x.jpg" alt="">
                      </div>
                      <div class="inline m-l-10">
                        <p class="no-margin text-white fs-12 text-master"><strong class="text-master">Super Sport</strong></p>
						            <p class="rating text-master">หมวดหมู่แบรนด์</p>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>-->
          <!-- END ITEM -->
          @forelse($brands as $brand)
            <!-- START ITEM -->
            <div class="card col1-element col-centered" data-social="item">
              <div class="gallery-item gallery-brand" data-height="1" data-width="1">
                @if(file_exists($brand->logo_image))
                  <a class="brand-event-url" title="{{ $brand->name }}" href="{{ URL::to('brand', $brand->url_slug) }}"><img src="" class="img-responsive" /></a>
                @else
                  <a class="brand-event-url" title="{{ $brand->name }}" href="{{ URL::to('brand', $brand->url_slug) }}"><img src="{{ URL::asset('/assets/img/gallery/' . rand(1,14) . '.jpg') }}" class="img-responsive" /></a>
                @endif
                <div class="overlayer bottom-left full-width">
                  <div class="overlayer-wrapper item-info ">
                    <div class="gradient-grey p-l-20 p-r-20 p-t-20 p-b-5">
                      <div class="">
                        <a class="brand-event-url" title="{{ $brand->name }}" href="{{ URL::to('brand', $brand->url_slug) }}"><p class="pull-left bold text-white fs-14 p-t-10">{{ $brand->name }}</p></a>
                        <a href="#" class="pull-right semi-bold text-white p-t-10"><i class="fa fa-heart-o fa-lg"></i></a>
                        <!--<h5 class="pull-right semi-bold text-white font-montserrat bold">$25.00</h5>-->
                        <div class="clearfix"></div>
                      </div>
                      <div class="m-t-10">
                        <div class="thumbnail-wrapper d32 circular m-t-5">&nbsp;</div>
                        <!--<div class="thumbnail-wrapper d32 circular m-t-5">
                          <img width="40" height="40" alt="" data-src-retina="assets/img/profiles/avatar2x.jpg" data-src="assets/img/profiles/avatar.jpg" src="assets/img/profiles/avatar.jpg">
                        </div>
                        <div class="inline m-l-10">
                          <p class="no-margin text-white fs-12">Designed by Alex Nester</p>
                          <p class="rating">
                            <i class="fa fa-star rated"></i>
                            <i class="fa fa-star rated"></i>
                            <i class="fa fa-star rated"></i>
                            <i class="fa fa-star rated"></i>
                            <i class="fa fa-star"></i>
                          </p>
                        </div>
                        <div class="pull-right m-t-10">
                          <button type="button" class="btn btn-white btn-xs btn-mini bold fs-14">+</button>
                        </div>
                        -->
                        <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END ITEM -->
          @empty
          @endforelse
        </div>
        <input type="hidden" value="{{ $more_page }}"  id="more_page" />
        <input type="hidden" value="{{ $total_page }}"  id="total_page" />
        <input type="hidden" value="{{ $paginate }}"  id="paginate_page" />
        <!-- END DAY -->
      </div>
      <!-- END FEED -->
      <div class="pagination" id="pagination" style="display: none"><a id="next" href="#">next page?</a></div>
    </div>
    <!-- END CONTAINER FLUID -->
  </div>
  <!-- /container -->
</div>
@stop
