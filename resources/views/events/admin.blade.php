@extends('layouts.admin')
@section('page_title', 'Administrator')
@section('content')

<div class="social-wrapper">
  <div class="social-test" data-pages="social">
    <div class="container-fluid container-fixed-lg bg-white sm-p-l-10 sm-p-r-10 m-t-20">

      <!-- START PANEL -->
      <div class="panel panel-transparent">
        <div class="panel-heading">
          <div class="panel-title">Table Event Lists
          </div>
          <div class="export-options-container-no pull-right">
            <div class="col-xs-12">
              <a href="/events/create" id="show-modal" class="btn btn-primary btn-cons"><i class="fa fa-plus"></i> Add Event</a>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="panel-body">
          <table class="table table-striped" id="tableWithExportOptionsNo">
            <thead>
              <tr>
                <th>Action</th>
                <th>Title</th>
                <th>Brand</th>
                <th>Start Date</th>
                <th>End Date</th>
              </tr>
            </thead>
            <tbody>

              @forelse($events as $event)
              <tr class="odd gradeX">
                <td><a href="/events/{{ $event->id }}/edit" id="show-modal" class="btn btn-danger btn-sm"><i class="fa fa-magic"></i> Edit</a></td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->brand->name }}</td>
                <td class="center">{{ $event->start_date_thai }}</td>
                <td class="center">{{ $event->end_date_thai }}</td>
              </tr>
              @empty
              @endforelse

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
