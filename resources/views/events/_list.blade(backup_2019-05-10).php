@extends('layouts.document')

@section('page_title', 'รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง')

@if($events->count() > 0)

  @section('og_url', URL::to('events', rawurldecode($events->first()->url_slug)))

  @section('og_title', $events->first()->title)

  @section('og_description', $events->first()->brief)

  @section('og_image', URL::to($events->first()->image))

@endif

@section('content')



<div class="social-wrapper">

  <div class="social-element" data-pages="social">

    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">

      <div class="m-b-5">&nbsp;</div>

      @if($events->count() < 1)

      <div class="p-l-0 col-md-12 promotion-empty text-master">ยังไม่มีโปรโมชั่น ในขณะนี้...</div>

      @endif



      <div class="feed">

        <!-- START DAY -->

        <div class="day" data-social="day">

          <!-- START ITEM -->

          <div class="card col2-element col-centered" data-social="item">

            <div class="gallery-item" data-width="2" data-height="2">

              <div class="live-tile slide" data-speed="750" data-delay="4000" data-mode="carousel">

                <div class="slide-front">

                  <!--<a href="http://goo.gl/EpwACY" target="_blank" title="ข้อเสนอสุดพิเศษจากบราเดอร์"><img src="{{ GlideImage::create('/images/partner_welovepro.jpg')->modify(['w'=> 640, 'fm'=>'jpg'])->save('/images/partner_welovepro.jpg') }}" class="img-responsive" /></a>-->
                  <a href="http://goo.gl/EpwACY" target="_blank" title="ข้อเสนอสุดพิเศษจากบราเดอร์"><img src="{{ '/images/partner_welovepro.jpg' }}" class="img-responsive" /></a>
                  
                </div>

                <!--<div class="slide-front">

                  <img src="{{ GlideImage::load('/images/events/2016-03-30/gallery/43/20160330-141855-Promotion-Reebok-Grand-Sale-2016-Sale-up-to-70-Off.png')->modify(['w'=> 640, 'fm'=>'jpg']) }}" class="img-responsive" />

                </div>

                <div class="slide-back">

                  <img src="{{ GlideImage::load('/images/events/2016-03-30/20160330-120609-Promotion-Crocs-End-Of-Season-Sale-up-to-50-Mar.2016.jpg')->modify(['w'=> 640, 'fm'=>'jpg']) }}" class="img-responsive" />

                </div>-->

              </div>

              <!--<div class="overlayer bottom-left full-width">

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

              </div>-->

            </div>

          </div>

          <!-- END ITEM -->



          @forelse($events as $event)

          <!-- START ITEM -->

          <article id="{{ $event->id }}" class="card col1-element col-centered" data-social="item" data-col="column">

            <div class="panel no-border  no-margin">

              <div class="padding-10">

                <div class="item-header clearfix">

                  <a class="brand-event-url" title="{{ $event->brand->name }}" href="{{ URL::to('brand', $event->brand->url_slug) }}">

                    <div class="thumbnail-wrapper d32 circular">

                      @if(file_exists($event->brand->logo_image))

                        <!--<img width="40" height="40" src="{{ GlideImage::load($event->brand->logo_image)->modify(['w'=> 100]) }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />-->
                        <!--<img width="40" height="40" src="{{ GlideImage::create($event->brand->logo_image)->modify(['w'=> 100])->save($event->brand->logo_image) }}" data-src="" data-src-retina="" alt="{{ $event->brand->name }}" />-->
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
                    <!--<a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ GlideImage::create($event->image)->modify(['w'=> 298, 'filt'=>''])->save($event->image) }}" srcset="{{ GlideImage::create($event->image)->modify(['w'=> 298, 'filt'=>''])->save($event->image) }} 298w, {{ GlideImage::create($event->image)->modify(['w'=> 640, 'filt'=>''])->save($event->image) }} 640w" data-src="{{ GlideImage::create($event->image)->modify(['w'=> 298, 'filt'=>''])->save($event->image) }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>-->
                    <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }} {{ $event->image }}"><img src="{{ $event->image }}?w=200&h=200&fit=crop" data-src="{{ $event->image }}" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>
                  @else

                    <!--<a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ URL::asset('assets/img/logo-bw.png') }}" srcset="" data-src="" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>-->
                    <a href="{{ URL::to('/', rawurldecode($event->url_slug)) }}" title="{{ $event->title }}"><img src="{{ URL::asset('assets/img/logo.png') }}" srcset="" data-src="" class="block center-margin relative img-responsive" alt="{{ $event->title }}" /></a>

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

          @empty

          @endforelse

          <!--<div class="clearfix yy">&nbsp;</div>-->

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

