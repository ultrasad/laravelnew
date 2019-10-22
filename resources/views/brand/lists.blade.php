@extends('layouts.admin')
@section('page_title', 'Brand Lists')
@section('content')

<div class="social-wrapper">
  <div class="social-test" data-pages="social">
    <div class="container-fluid container-fixed-lg bg-white sm-p-l-10 sm-p-r-10 m-t-20">

      <!-- START PANEL -->
      <div class="panel panel-list panel-transparent">
        <div class="panel-heading">
          <div class="panel-title">Table Brand Lists
          </div>
          <div class="export-options-container-no pull-right">
            <div class="col-xs-12">
              <a href="/brand/register" id="show-modal" class="btn btn-xs btn-primary btn-cons"><i class="fa fa-plus"></i> Add Brand</a>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="panel-body">
          <table class="table table-striped" id="tableWithExportOptionsNo">
            <thead>
              <tr>
                <th data-class="expand">Action</th>
                <th>Name</th>
                <th>Slogan</th>
                <th data-hide="phone,tablet">Created</th>
                <th data-hide="phone,tablet">Approved</th>
              </tr>
            </thead>
            <tbody>

              @forelse($brands as $brand)
              <tr class="odd gradeX">
                <td><a href="/brand/{{ $brand->id }}/edit" id="show-modal" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-magic"></i> Edit</a></td>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->slogan }}</td>
                <td class="center">{{ date('Y-m-d', strtotime($brand->created_at)) }}</td>
                <td class="center">{{ $brand->approve_status }}</td>
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
