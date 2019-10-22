@extends('layouts.document')
@section('page_title', $brand->name . ' - รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง')
@section('content')

<div class="social-wrapper">
  <div class="social-element" data-pages="social">
    <!-- START JUMBOTRON -->
    <div class="jumbotron" data-pages="parallax" data-social="cover">
      <div class="cover-photo">
        <img alt="Cover photo" src="{{ URL::asset('assets/img/social/cover.png') }}" />
      </div>
      <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
        <div class="inner">
          <div class="pull-bottom bottom-left m-b-40">
            <h5 class="text-white no-margin">welcome to pages brand</h5>
            <h1 class="text-white no-margin"><span class="semi-bold">{{ $brand->name }}</span></h1>
          </div>
        </div>
      </div>
    </div>
    <!-- END JUMBOTRON -->

    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10 m-b-10 brand-master">
      <div class="col-md-12 sm-padding-0">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 sm-padding-0">
          <a class="brand-event-url" title="{{ $brand->name }}" href="{{ URL::to('brand', $brand->url_slug) }}">
            <div class="thumbnail-wrapper d100 circular">
              <img width="100" height="100" src="{{ file_exists($brand->logo_image) ? URL::asset($brand->logo_image) : URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $brand->name }}" />
            </div>
          </a>
          <div class="inline m-l-10">
            <h3 class="m-b-5"><strong class="text-master"><a class="brand-event-url" title="{{ $brand->name }}" href="{{ URL::to('brand', $brand->url_slug) }}">{{ $brand->name }}</a></strong><i class="fa fa-check-circle padding-5 text-success" aria-hidden="true"></i></h3>
            <p class="hint-text-9">
              <span class="text-slogan">{{ $brand->slogan }}</span>
            </p>
            @if(!empty($brand->category->first()->name))
              <div class="hint-text small-text text-master"><a href="{{ URL::to('category', $brand->category->first()->category) }}" title="{{ $brand->category->first()->name }}" class="">{{ $brand->category->first()->name }}</a></div>
            @else
              <div class="hint-text small-text text-master"><a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุหมวดหมู่" class="">ไม่ระบุหมวดหมู่</a></div>
            @endif
          </div>
        </div>

        <div class="col-lg-5 col-xs-12 sm-p-l-0 hidden-md visible-xs visible-lg">
          <p class="m-t-10 sm-p-t-10 sm-p-l-5 hint-text text-master">{{ $brand->detail or 'No Description.' }}</p>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 sm-p-t-10 sm-p-l-0 brand-master-social">
            @if(!empty($brand->branch->first()->name))
              <p class="m-t-10 hint-text text-master"><a class="btnToggleMap" href="#modal_map" data-toggle="modal" data-type="brand" data-slug="{{ $brand->url_slug }}" title="{{ $brand->name }} มีทั้งหมด {{ $brand->branch->count() }} สาขา"><i class="pg-map pg-map-lg"></i>&nbsp; มีทั้งหมด {{ $brand->branch->count() }} สาขา</a></p>
            @endif
            @if($brand->facebook != '')
              <p class="hint-text text-master"><a href="{{ $brand->facebook }}" target="_blank" title="{{ $brand->name }} Facebook: {{ $brand->facebook }}"><i class="fa fa-facebook fa-lg p-l-5"></i>&nbsp; {{ $brand->facebook }}</a></p>
            @endif
            @if($brand->twitter != '')
              <p class="hint-text text-master"><a href="{{ $brand->twitter }}" target="_blank" title="{{ $brand->name }} Twitter: {{ $brand->twitter }}"><i class="fa fa-twitter fa-lg p-l-5"></i>&nbsp; {{ $brand->twitter }}</a></p>
            @endif
            @if($brand->line_officail != '')
              <p class="hint-text text-master"><a href="{{ $brand->line_officail }}" target="_blank" title="{{ $brand->name }} Line Official: {{ $brand->line_officail }}"><i class="fa fa-heart fa-lg p-l-5"></i>&nbsp; {{ $brand->line_officail }}</a></p>
            @endif
            @if($brand->youtube != '')
              <p class="hint-text text-master"><a href="{{ $brand->youtube }}" target="_blank" title="{{ $brand->name }} Yuotube: {{ $brand->youtube }}"><i class="fa fa-youtube fa-lg p-l-5"></i>&nbsp; {{ $brand->youtube }}</a></p>
            @endif
        </div>

        <div class="col-lg-5 col-md-12 hidden-lg hidden-xs">
          <p class="m-t-10 sm-p-t-10 sm-p-l-5 hint-text text-master">{{ $brand->description or 'No Description.' }}</p>
        </div>

      </div>
    </div>

    <div class="clearfix m-b-20 brand-master-border">&nbsp;</div>

    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
      @if($events->count() < 1)
      <div class="p-l-0 col-md-12 promotion-empty text-master">ยังไม่มีโปรโมชั่น ในขณะนี้...</div>
      @endif
      <div class="feed">
        <!-- START DAY -->
        <div class="day" data-social="day">
          <!-- START ITEM -->
          <div class="card no-border bg-transparent full-width" data-social="item"></div>
          <!-- END ITEM -->
          @forelse($events as $event)
          <!-- START ITEM -->
          <div class="card col1-element col-centered" data-social="item" data-col="column">
            <div class="panel no-border  no-margin">
              <div class="padding-10">
                <div class="item-header clearfix">
                  <a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">
                    <div class="thumbnail-wrapper d32 circular">
                      <!--<img width="40" height="40" src="{{ file_exists($event->brand->logo_image) ? URL::asset($event->brand->logo_image) : URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />-->
                      @if(file_exists($event->brand->logo_image))
                        <img width="40" height="40" src="/img/{{ $event->brand->logo_image }}?w=100" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
                      @else
                        <img width="40" height="40" src="{{ URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
                      @endif
                    </div>
                  </a>
                  <div class="inline m-l-10">
                    <p class="no-margin">
                      <strong class="text-master"><a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">{{ $event->brand->name }}</a></strong>
                    </p>
                    @if(!empty($brand->category->first()))
                      <div class="hint-text small-text text-master"><a href="{{ URL::to('category', $brand->category->first()->category) }}" title="{{ $brand->category->first()->name }}" class="">{{ $brand->category->first()->name }}</a></div>
                    @else
                      <div class="hint-text small-text text-master"><a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุหมวดหมู่" class="">ไม่ระบุหมวดหมู่</a></div>
                    @endif
                  </div>
                  <div class="pull-top pull-right list-inline">
                    <a href="#modal_map" data-toggle="modal" class="btntoggle btnToggleMap" data-type="promotion" data-id="{{ $event->id }}" data-slug="{{ $event->url_slug }}" title="ที่ตั้งสาขา {{ $event->brand->name }}"><i class="pg-map"></i></a>
                  </div>
                </div>
              </div>
              <hr class="no-margin">
              <div class="relative">
                <div class="no-overflow">
                  <!--<a href="{{ URL::to('/', $event->url_slug) }}" title="{{ $event->title }}"><img src="{{ URL::asset($event->image) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>-->
                  <!--<a href="{{ URL::to('/', $event->url_slug) }}" title="{{ $event->title }}"><img src="{{ GlideImage::load($event->image)->modify(['w'=> 298, 'filt'=>'']) }}" srcset="{{ GlideImage::load($event->image)->modify(['w'=> 298, 'filt'=>'']) }} 298w, {{ GlideImage::load($event->image)->modify(['w'=> 640, 'filt'=>'']) }} 640w" data-src="{{ GlideImage::load($event->image)->modify(['w'=> 298, 'filt'=>'']) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>-->
                  @if(is_file($event->image))
                    <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="/img/{{ $event->image }}?w=298" srcset="/img/{{ $event->image }}?w=298 298w, /img/{{ $event->image }}?w=640 640w" data-src="/img/{{ $event->image }}?w=298" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                  @else
                    <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ $event->image }}" srcset="" data-src="" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                  @endif
                </div>
              </div>
              <div class="p-t-15 p-l-15 p-r-15 p-b-5">
                <strong class="text-master"><a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}" class="card_title">{{ $event->title }}</a></strong>
                <p>{{ $event->brief }}</p>
              </div>
              <div class="p-t-10 p-l-15 p-r-15 p-b-5 card_footer">
                <div class="pull-left text-master hint-text fs-12 color-body">ถึงวันที่ : {{ $event->end_date_thai }}</div>
                <ul class="list-inline pull-right no-margin hint-text">
                  <li><a class="text-info-link" href="#fb comment"><span>5,345</span> <i class="fs-12 pg-comment"></i></a>
                  </li>
                  <li><a class="text-info-link heart" href="#"><span>23K</span> <i class="fa fa-heart-o"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
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
