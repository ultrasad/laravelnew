@extends('layouts.admin')
@section('page_title', 'Administrator')
@section('content')

<div class="social-wrapper">
  <div class="social-test" data-pages="social">
    <div class="container-fluid container-fixed-lg bg-white sm-p-l-10 sm-p-r-10 m-t-20">

      <div class="panel-body">
        <div class="panel-heading padding-0">
          <div class="panel-title p-l-0 pull-left">Table Event Lists</div>
          <div class="pull-right">
              <a href="/events/create" id="show-modal" class="btn btn-primary btn-xs pull-right"><i class="fa fa-plus"></i> สร้างโปรโมชั่นใหม่</a>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="row m-t-10">
          <div class="col-md-6 col-xs-12">
            <div class="form-group form-group-default input-group col-xs-12">
              <label>โปรโมชั่น</label>
              <input type="text" name="title" class="form-control title" id="title" placeholder="โปรโมชั่น" />
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <!--<div class="form-group form-group-default input-group col-xs-12">
              <label>แบรนด์</label>
              <input type="text" name="brand" class="form-control brand" placeholder="แบรนด์" required />
            </div>-->
            <div class="form-group form-group-default form-group-normal form-group-select form-group-cs-select2">
              <label>แบรนด์</label>
              <select class="full-width cs-select2 validate" name="brand" id="cs-select2" data-init-plugin="select2">
                @if($brands->count() > 1)
                <option value="">ทั้งหมด</option>
                @endif
                @if($brands)
                  @foreach($brands as $id => $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="pull-right">
            <a href="javascript: void(0);" id="show-modal" class="btn btn-success btn-xs btn-search-event pull-right"><i class="fa fa-search"></i> ค้นหา โปรโมชั่น</a>
        </div>
      </div>

      <!-- START PANEL -->
      <div class="panel panel-list panel-transparent">
        <div class="panel-body p-t-0">
          <table class="table table-striped dataTable no-footer table-list-admin" id="table_event_list_admin"  width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="all" width="120">Action</th>
                <th class="all">Title</th>
                <th class="min-phone-l">Brand</th>
                <th class="desktop">Start Date</th>
                <th class="desktop">End Date</th>
                <!--
                <th width="120">Action</th>
                <th>Title</th>
                <th data-hide="phone">Brand</th>
                <th data-hide="phone,tablet">Start Date</th>
                <th data-hide="phone,tablet">End Date</th>
                -->
              </tr>
            </thead>
            <tbody>

              {{--
              @forelse($events as $event)
              <tr class="odd gradeX">
                <td><a href="/events/{{ $event->id }}/edit" id="show-modal" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-magic"></i> Edit</a></td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->brand->name }}</td>
                <td class="center">{{ $event->start_date_thai }}</td>
                <td class="center">{{ $event->end_date_thai }}</td>
              </tr>
              @empty
              @endforelse
              --}}

            </tbody>
          </table>
        </div>
      </div>
      <!-- END PANEL -->

    </div>
    <!-- END CONTAINER FLUID -->
  </div>
  <!-- /container -->
</div>
@stop
