@extends('layouts.document')
@section('page_title', $event_title)
@section('og_url', URL::to('events', rawurldecode($event->url_slug)))
@section('og_title', $event_title)
@section('og_description', $event->brief)
@section('og_image', URL::to($event->image))
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
        <li>
          @if(!empty($event->brand->category->first()->name))
            <a href="{{ URL::to('category', $event->brand->category->first()->category) }}" title="{{ $event->brand->category->first()->name }}">{{ $event->brand->category->first()->name }}</a>
          @else
            <a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุ หมวดหมู่">ไม่ระบุ หมวดหมู่</a>
          @endif
        </li>
        <li><span class="p-l-5 m-l-5 fs-12">{{ $event->title }}</span>
        </li>
      </ul>
      <!-- END BREADCRUMB -->
    </div>
  </div>
</div>
<!-- END JUMBOTRON -->
<!-- START CONTAINER FLUID -->
<!--<form role="form">-->

<article id="event-{{ $event->id }}">
<div class="container-fluid container-fixed-lg">
  <!-- BEGIN PlACE PAGE CONTENT HERE -->
  <div class="row">
    <div class="col-md-8 event-gallery">
      <div class="panel-body p-b-0 p-l-0 p-r-0">
        <div class="dialog__content">
            <!-- START PANEL -->
            <div class="fotorama" data-allowfullscreen="true" data-maxwidth="800"  data-width="100%" data-click="false" data-arrows="always" click="false" data-nav="thumbs" data-loop="true" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
              @forelse($event->gallery_list as $id => $image)
                @if($id == 0)
                  @if(is_file($event->image))
                    <img itemprop="url" content="img/{{ $event->image }}?w=640" src="img/{{ $event->image }}?w=640" srcset="img/{{ $event->image }}?w=298 298w, img/{{ $event->image }}?w=640 640w" data-src="img/{{ $event->image }}?w=640" class="block center-margin relative img-responsive" alt="{{ $event->title }}" />
                  @else
                    <img itemprop="url" content="{{ $event->image }}" src="{{ $event->image }}" srcset="" data-src="" class="block center-margin relative img-responsive" alt="{{ $event->title }}" />
                  @endif
                @endif
                <img itemprop="url" content="img/{{ $image }}?w=640" src="img/{{ $image }}?w=640"  data-thumb="img/{{ $image }}?w=100&h=100&fit=crop" class="fotoclick" class="img-responsive" />
              @empty
                @if(is_file($event->image))
                  <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="img/{{ $event->image }}?w=640" srcset="img/{{ $event->image }}?w=298 298w, img/{{ $event->image }}?w=640 640w" data-src="img/{{ $event->image }}?w=640" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                @else
                  <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ $event->image }}" srcset="" data-src="" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                @endif
              @endforelse
            </div>
            <!-- END PANEL -->
        </div>
     </div>
    </div>
	<header class="entry-header">
    <div class="col-md-4 body-brief">
      <div class="panel-body body-brief p-l-0 p-r-0">
        <div class="no-margin fs-15 hint-text-9 text-master">
          <h4 class="event-category">
            @if(!empty($event->brand->category->first()->name))
                <a class="category-event-url" href="{{ URL::to('category', $event->brand->category->first()->category) }}" title="{{ $event->brand->category->first()->name }}">{{ $event->brand->category->first()->name }}</a>
            @else
                <a class="category-event-url" href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุ หมวดหมู่">ไม่ระบุ หมวดหมู่</a>
            @endif
          </h4>
        </div>
        <!-- START PANEL -->
        <h1 itemprop="name headline" class="text-master m-t-20 event-title">{{ $event->title }}</h1>
        <p>{{ $event->brief }}</p>
        <p>&nbsp;</p>
        <div class="item-header clearfix">
          <a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">
            <div class="thumbnail-wrapper d32 circular">
              @if(file_exists($event->brand->logo_image))
                <img width="40" height="40" src="img/{{ $event->brand->logo_image }}?w=100" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
              @else
                <img width="40" height="40" src="{{ URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
              @endif
            </div>
          </a>
          <div class="inline m-l-10">
            <p class="no-margin">
              <h2 class="text-master event-brand"><a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">{{ $event->brand->name }}</a></h2>
            </p>
            @if(!empty($event->brand->category->first()->name))
                <h3 class="no-margin hint-text text-master event-brand"><a class="category-brand-url" href="{{ URL::to('/category', $event->brand->category->first()->category) }}" title="{{ $event->brand->category->first()->name }}">{{ $event->brand->category->first()->name }}</a></h3>
            @else
                <h3 class="no-margin hint-text text-master"><a class="category-brand-url" href="{{ URL::to('/category', 'unknow') }}" title="ไม่ระบุ หมวดหมู่">ไม่ระบุ หมวดหมู่</a></h3>
            @endif
          </div>
        </div>
        <p>&nbsp;</p>
        @if(date('Y-m-d', strtotime($event->end_date)) > (\Carbon\Carbon::now()))
        <p class="col-middle m-b-5">
          <span class="text-complete text-master"><i class="fa fa-circle m-r-10"></i>{{ $event->start_date_thai }} - {{ $event->end_date_thai }}</span>
        </p>
        <!--<p class="col-middle m-b-5">
          <span class="text-danger text-master"><i class="fa fa-circle m-r-10"></i>{{ $event->check_expire }}</span>
        </p>-->
        @else
        <p class="col-middle m-b-5">
          @if(!starts_with($event->end_date, '-000'))
            <span class="text-danger text-master"><i class="fa fa-circle m-r-10"></i>{{ $event->start_date_thai }} - {{ $event->end_date_thai }} (หมดโปรโมชั่นแล้ว)</span>
          @else
            <span class="text-danger text-master"><i class="fa fa-circle m-r-10"></i>{{ $event->start_date_thai }} - {{ $event->end_date_thai }}</span>
          @endif
        </p>
        @endif
        <p>&nbsp;</p>
        <p class="col-middle m-b-5">
          <div class="btn-social-group inline">
            <div class="inline btn-social btn-facebook"><a class="fb-like" data-href="{{ URL::to('events', rawurldecode($event->url_slug)) }}" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></a></div><div class="inline btn-social btn-twitter"><a href="https://twitter.com/share" class="twitter-share-button"></a></div>
            <div class="inline btn-social btn-line-official"><a href="http://line.me/R/msg/text/?{{ $event_title }}%0D%0A{{ URL::to('/', rawurldecode($event->url_slug)) }}"><img width="76px" height="20px" alt="LINE it!" src="{{ URL::asset('assets/img/linebutton.png')}}"></a></div>
          </div>
        </p>
        <!--<small class="fs-12 hint-text">15 January 2015, 06:50 PM</small>-->
        <!-- END PANEL -->
      </div>
    </div>
	</header>
  </div>

  <div class="col-md-12"><hr /></div>
  @if(!empty($branchs))
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="panel-body p-t-0 p-b-15 p-l-0 p-r-0 event-branch-list text-master">
            <!-- <hr class="p-b-t-1 m-t-10 m-b-10" /> -->
            <u><b>{{ $event->brand->name }} สาขาที่ร่วมรายการ</b></u>
            <span class="event">
              @if(!empty($branchs))
                {!! implode(', ', $branchs) !!}
              @else
                <span class="text-danger">ไม่ระบุสาขา</span>
              @endif
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>

@if(!empty($branchs))
<div class="map_wide">
  <div id="map_canvas" class="map-canvas map-show"></div>
  <input name="location_lat" type="hidden" id="location_lat" value="0" />
  <input name="location_lon" type="hidden" id="location_lon" value="0" />
  <input name="location_zoom" type="hidden" id="location_zoom" value="0" />
</div>
@endif

<div class="bg-write p-t-10 description">
  <div class="container-fluid container-fixed-lg">
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
              <div class="panel-body p-t-10 hint-text-9 p-l-0 p-r-0" id="content-description">
                <h4 class="text-master m-b-30 text-big-title">รายละเอียดโปรโมชั่น</h4>
                <p itemprop="articleBody">{!! $event->description !!}</p>
                <div class="desc-footer hint-text p-t-5 p-b-5 m-t-20 m-b-30">
                    <div temprop="datePublished" content="{{ date('Y-m-d', strtotime($event->created_at)) }}" class="pull-left inline event-created b-grey b-r"><b>Date : </b>{{ date('j F Y', strtotime($event->created_at)) }}&nbsp;&nbsp;</div>
					<meta itemprop="dateModified" content="{{ date('Y-m-d', strtotime($event->update_at)) }}"/>
                    <div class="pull-left inline event-author b-grey b-r"><b>Author : </b><span itemprop="author" itemscope itemtype="http://schema.org/Person"><a title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}" itemprop="url"><span itemprop="name">{{ $event->brand->name }}</span>&nbsp;&nbsp;</a></span></div>
                    <div class="pull-left inline event-publisher"><b>Publisher : </b><span itemprop="publisher" itemscope itemtype="http://schema.org/Organization"><a href="https://plus.google.com/u/0/118252063966470784089" title="welovero" itemprop="url" rel="publisher"><span itemprop="name">welovepro</span></a></span></div>
                    <div class="clearfix">&nbsp;</div>
                </div>
              </div>
              @if(!empty($tags))
              <div itemprop="keywords" class="col-md-12 text-master p-l-0 p-r-0">
                {!! implode(', ', $tags) !!}
              </div>
              @endif
              <div class="col-sm-12 visible-xs visible-sm p-t-20 p-l-0 p-r-0">
                <div class="ads">
                  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- welovepro-news-side -->
                  <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-6376653037162976"
                     data-ad-slot="3710220418"></ins>
                  <script>
                  (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
                </div>
                <div class="ads">
                  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- welovepro_SideLong_300x600 -->
                  <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:600px"
                     data-ad-client="ca-pub-6376653037162976"
                     data-ad-slot="8590767793"></ins>
                  <script>
                  (adsbygoogle = window.adsbygoogle || []).push({});
                  </script>
                </div>
              </div>
              <div class="col-md-12 p-l-0 p-r-0">
                @if($relates->count() > 0)
                  <p>&nbsp;</p>
                  <h4 class="text-master m-b-30 text-big-title"><i class="fa fa-heartbeat" aria-hidden="true"></i>&nbsp;โปรโมชั่นที่คุณอาจสนใจ</h4>
                @endif
                <div class="row relate event-relate">
                  @forelse($relates as $relate)
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 p-l-10 p-r-10 m-b-20 padding-right-active col-relate">
                    <div class="relative col-md-12 thumb padding-0 p-b-0">
                      <a title="{{ $relate->title }}" href="{{ rawurldecode($relate->url_slug) }}"><div class="relate-img-thumb" style="background-image: url({{ URL::asset($relate->image) }});"></div></a>
                      <!--<a title="{{ $relate->title }}" href="{{ $relate->url_slug }}"><img alt="{{ $relate->title }}" class="block center-margin relative full-width img-responsive relate-img-thumb" src="{{ URL::asset($relate->image) }}" /></a>-->
                    </div>
                    <div class="col-md-12 brief p-l-10 p-r-10 card-relate-body">
                        <div class="padding-5 p-t-10 text-master block-ellipsis">
                          <h2 class="text-master events-title-boxed"><a title="{{ $relate->title }}" href="{{ rawurldecode($relate->url_slug) }}" class="card_title">{{ $relate->title }}</a></h2>
                        </div>
                    </div>
                    <div class="row col-md-12 padding-0 m-l-0 m-r-0 footer-relate">
                      <div class="p-t-10 p-l-15 p-r-15 p-b-5 card_footer">
                        <div class="pull-left text-master hint-text fs-12 color-body">ถึงวันที่ : {{ $relate->end_date_thai }}</div>
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
                  @empty
                  @endforelse
                </div>
              </div>
              <div class="fb-comment full-width p-l-0 p-r-0">
				<h4 class="text-master m-b-30 text-big-title">ความคิดเห็น</h4>
                <div class="fb-comments full-width" data-href="{{ URL::to(rawurldecode($event->url_slug)) }}" data-width="100%" data-numposts="10"></div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 hidden-xs hidden-sm">
        <div class="panel-body p-l-0 p-r-0">
            <div class="ads">
              <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
              <!-- welovepro-news-side -->
              <ins class="adsbygoogle"
                 style="display:inline-block;width:300px;height:250px"
                 data-ad-client="ca-pub-6376653037162976"
                 data-ad-slot="3710220418"></ins>
              <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
              </script>
            </div>
            <div class="ads">
              <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
              <!-- welovepro_SideLong_300x600 -->
              <ins class="adsbygoogle"
                 style="display:inline-block;width:300px;height:600px"
                 data-ad-client="ca-pub-6376653037162976"
                 data-ad-slot="8590767793"></ins>
              <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
              </script>
            </div>
        </div>
      </div>
    </div>
    <!-- END PLACE PAGE CONTENT HERE -->
  </div>
</div>
<input type="hidden" name="event_id" id="event_id" class="event_id" value="{{ $event->id }}" />
<input type="hidden" name="event_slug" id="event_slug" class="event_slug" value="{{ rawurldecode($event->url_slug) }}" />
<!--</form>-->
<!-- END CONTAINER FLUID -->
</article>
@stop
