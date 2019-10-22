@extends('layouts.document')
@section('page_title', 'Promotion List, Category: ' . $category_name)
@section('content')

<!-- START JUMBOTRON -->
<div class="jumbotron m-b-15" data-pages="parallax">
  <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
    <div class="inner">
      <!-- START BREADCRUMB -->
      <ul class="breadcrumb">
        <li>
          <p>Brand Category</p>
        </li>
        <li><a href="#" class="active">{{ $category_name }}</a>
        </li>
      </ul>
      <!-- END BREADCRUMB -->
    </div>
  </div>
</div>
<!-- END JUMBOTRON -->

<div class="social-wrapper">
  <div class="social-element" data-pages="social">
    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
      @if($events->count() < 1)
      <div class="col-md-12 promotion-empty text-master">ยังไม่มีโปรโมชั่น ในหมวดหมู่นี้...</div>
      @endif
      <div class="feed">
        <!-- START DAY -->
        <div class="day" data-social="day">
          @forelse($events as $event)
          <!-- START ITEM -->
          <div class="card col1-element col-centered" data-social="item" data-col="column">
            <div class="panel no-border  no-margin">
              <div class="padding-15">
                <div class="item-header clearfix">
                  <div class="thumbnail-wrapper d32 circular">
                    <img width="40" height="40" src="{{ file_exists($event->brand->logo_image) ? URL::asset($event->brand->logo_image) : URL::asset('assets/img/profiles/e.jpg') }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />
                  </div>
                  <div class="inline m-l-10">
                    <p class="no-margin">
                      <strong class="text-master">{{ $event->brand->name }}</strong>
                    </p>
                    @if(!empty($event->brand->category_first->name))
                        <p class="no-margin hint-text text-master"><a class="category-brand-url" href="{{ URL::to('brand/category', $event->brand->category_first->category) }}" title="{{ $event->brand->category_first->name }}">{{ $event->brand->category_first->name }}</a></p>
                    @else
                        <p class="no-margin hint-text text-master"><a class="category-brand-url" href="{{ URL::to('brand/category', 'unknow') }}" title="Unknow">ไม่ระบุ หมวดหมู่</a></p>
                    @endif
                    {{--
                    @if($category_name != 'unknow')
                        <p class="no-margin hint-text"><a class="category-brand-url" href="{{ URL::to('category', $event->category_first->category) }}" title="{{ $event->category_first->name }}">{{ $event->category_first->name }}</a></p>
                    @else
                        <p class="no-margin hint-text"><a class="category-brand-url" href="{{ URL::to('category', 'unknow') }}" title="Unknow">ไม่ระบุ หมวดหมู่</a></p>
                    @endif
                    --}}
                  </div>
                  <div class="pull-top pull-right list-inline">
                    <i class="pg-map"></i>
                  </div>
                </div>
              </div>
              <hr class="no-margin">
              <div class="relative">
                <div class="no-overflow">
                  <a href="{{ URL::to('events', $event->url_slug) }}" title="{{ $event->title }}"><img src="{{ URL::asset($event->image) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                </div>
              </div>
              <div class="padding-15">
                <strong class="text-master"><a href="{{ URL::to('events', $event->url_slug) }}" title="{{ $event->title }}" class="card_title">{{ $event->title }}</a></strong>
                <p>{{ $event->brief }}</p>
                {{-- <div class="hint-text small-text">via {{ $event->brand->first()->name }}</div> --}}
                @if(!empty($event->category->first()->name))
                  <div class="hint-text small-text text-master">via <a href="{{ URL::to('category', $event->category->first()->category) }}" title="{{ $event->category->first()->name }}" class="">{{ $event->category->first()->name }}</a></div>
                @else
                  <div class="hint-text small-text text-master">via <a href="{{ URL::to('category', 'unknow') }}" title="ไม่ระบุหมวดหมู่" class="">ไม่ระบุหมวดหมู่</a></div>
                @endif
              </div>
              <div class="padding-15 card_footer">
                <div class="pull-left">ถึงวันที่ : {{ $event->end_date_thai }}</div>
                <ul class="list-inline pull-right no-margin">
                  <li><a class="text-info-link" href="#"><span>5,345</span> <i class="fa fa-comment"></i></a>
                  </li>
                  <li><a class="text-info-link heart" href="#"><span>23K</span> <i class="fa fa-heart"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <!-- END ITEM -->
          @empty
          @endforelse
          <div class="clearfix">&nbsp;</div>
        </div>
        <!-- END DAY -->
      </div>
      <!-- END FEED -->
    </div>
    <!-- END CONTAINER FLUID -->
  </div>
  <!-- /container -->
</div>
@stop
