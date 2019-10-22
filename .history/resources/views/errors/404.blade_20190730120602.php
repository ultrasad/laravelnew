@extends('layouts.document')
@section('page_title')
    {!! $msg !!}
@stop
@section('og_url', URL::to('/'))
@section('og_title')
    {!! $msg !!}
@stop
@section('og_description')
    {!! $msg !!}
@stop
@section('og_image', '')
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
        <li></li>
      </ul>
      <!-- END BREADCRUMB -->
    </div>
  </div>
</div>
<!-- END JUMBOTRON -->
<!-- START CONTAINER FLUID -->
<!-- <form role="form"> -->

<article id="event-failed">
<div class="bg-write p-t-10 description">
  <div class="container-fluid container-fixed-lg">
    <div class="col-md-12">
      <div class="feed">
        <h1>{{ $msg or 'empty' }}</h1>
        <h3 class="m-t-50"><u>โปรโมชั่นล่าสุด!</u></h3>
        <!-- START DAY -->
        <div class="day" data-social="day">
          @foreach($events as $event)
            <!-- START ITEM -->
            <article id="{{ $event->id }}" class="card col1-element col-centered" data-social="item" data-col="column">
              <div class="panel no-border  no-margin">
                <div class="padding-10">
                  <div class="item-header clearfix">
                    <a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">
                      <div class="thumbnail-wrapper d32 circular">
                        @if(file_exists($event->brand->logo_image))
                          <!--<img width="40" height="40" src="{{ GlideImage::load($event->brand->logo_image)->modify(['w'=> 100]) }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />-->
                          <img width="40" height="40" src="{{ $event->brand->logo_image }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
                        @else
                          <img width="40" height="40" src="{{ URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
                        @endif
                      </div>
                    </a>
                    <div class="inline m-l-10">
                      <p class="no-margin">
                        <h3 class="text-master vcard author post-author events-info-boxed"><a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}"><span class="fn">{{ $event->brand->name }}</span></a></h3>
                      </p>
                      @if(!empty($event->brand->category->first()->name))
                        <h3 class="hint-text small-text text-master events-info-boxed"><a href="{{ URL::to('category', $event->brand->category->first()->category) }}" title="{{ $event->brand->category->first()->name }}" class="">{{ $event->brand->category->first()->name }}</a></h3>
                      @else
                        <h3 class="hint-text small-text text-master events-info-boxed"><a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุหมวดหมู่" class="">ไม่ระบุหมวดหมู่</a></h3>
                      @endif
                    </div>
                    @if(!empty($event->brand->branch->first()->name))
                    <div class="pull-top pull-right list-inline">
                      <a href="#modal_map" data-toggle="modal" class="btntoggle btnToggleMap" data-type="promotion" data-id="{{ $event->id }}" data-slug="{{ rawurldecode($event->url_slug) }}" title="ที่ตั้งสาขา {{ $event->brand->name }}"><i class="pg-map"></i></a>
                    </div>
                    @endif
                  </div>
                </div>
                <hr class="no-margin">
                <div class="relative">
                  <div class="no-overflow">
                    <!--<a href="{{ URL::to('/', $event->url_slug) }}" title="{{ $event->title }}"><img src="{{ URL::asset($event->image) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>-->
                    @if(is_file($event->image))
                      <!--<a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ GlideImage::load($event->image)->modify(['w'=> 298, 'filt'=>'']) }}" srcset="{{ GlideImage::load($event->image)->modify(['w'=> 298, 'filt'=>'']) }} 298w, {{ GlideImage::load($event->image)->modify(['w'=> 640, 'filt'=>'']) }} 640w" data-src="{{ GlideImage::load($event->image)->modify(['w'=> 298, 'filt'=>'']) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>-->
                      <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ $event->image }}" srcset="{{ $event->image }}" data-src="{{ $event->image }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                    @else
                      <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ $event->image }}" srcset="" data-src="" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                    @endif
                  </div>
                </div>
                <div class="p-t-15 p-l-15 p-r-15 p-b-5">
                  <header><h2 class="text-master events-title-boxed"><a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}" class="card_title">{{ $event->title }}</a></h2></header>
                  <p class="list-brief entry-content">{{ $event->brief }}</p>
                </div>
        			  <footer>
        				  <div class="p-t-10 p-l-15 p-r-15 p-b-5 card_footer">
        					<div class="pull-left text-master hint-text fs-12 color-body">ถึงวันที่ : {{ $event->end_date_thai }}</div>
        					<ul class="list-inline pull-right no-margin hint-text">
        					  <li><a class="text-info-link" href="#fb comment"><span>5,345</span> <i class="fs-12 pg-comment"></i></a>
        					  </li>
        					  <li><a class="text-info-link heart" href="#"><span>23K</span> <i class="fa fa-heart-o"></i></a>
        					  </li>
        					</ul>
        					<!--<div class="clearfix xx"></div>-->
        				  </div>
        			  </footer>
              </div>
            </article>
            <!-- END ITEM -->
          @endforeach
          <div class="clearfix">&nbsp;</div>
        </div>
      </div>

    </div>
    <!-- END PLACE PAGE CONTENT HERE -->
  </div>
</div>
<!--</form>-->
<!-- END CONTAINER FLUID -->
</article>
@stop
