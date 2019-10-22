@extends('layouts.admin')
@section('page_title', 'Events Create')
@section('content')
  <!-- START CONTAINER FLUID -->
  <form class="settings-form" id="settings-form" role="form" action="/admin" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="container-fluid container-fixed-lg">
    <div class="row">
      <div class="col-md-12 m-t-10">
        <h3 class='page-title p-l-10'>ตั้งค่าทั่วไป</h3>
        <span class="error-reponse">
          @include('errors.list')
        </span>
      </div>
      <div class="col-md-8">
        <!-- START PANEL -->
        <div class="panel panel-default">
          <div class="panel-body sm-p-t-20">
              <div class="form-group form-group-default required">
                <label>Meta Title</label>
                <input type="text" name="title" class="form-control" placeholder="ชื่อเว็บ" required />
              </div>
              <div class="form-group form-group-default form-group-area required">
                <label>Meta Deacription</label>
                <textarea class="form-control" name="site_deacription" rows="3" required></textarea>
              </div>
              <div class="form-group form-group-default input-group">
                <label>Meta Image</label>
                <input type="text" class="form-control" />
                <span class="input-group-addon btn-file">
                    <input type="file" name="site_image" class="form-control form-control-image" id="site_image" placeholder="รูปภาพ" readonly />
                    <i class="fa fa-picture-o icon-picture"></i>
                </span>
              </div>
              <div class="form-group form-group-default required">
                <label>Facebook</label>
                <input type="text" name="facebook_url" class="form-control" placeholder="URL Facebook" />
              </div>
              <div class="form-group form-group-default required">
                <label>Twitter</label>
                <input type="text" name="twitter_url" class="form-control" placeholder="URL Twitter" />
              </div>
              <div class="form-group form-group-default required">
                <label>Youtube</label>
                <input type="text" name="youtube_url" class="form-control" placeholder="URL Youtube" />
              </div>
              <div class="form-group form-group-default form-group-area required">
                <label>Email Contact (Separate with comma.)</label>
                <textarea class="form-control" name="site_deacription" rows="3" required></textarea>
              </div>
              <!-- END PANEL -->
          </div>

          <div class="panel-body">
            <button class="btn btn-success" type="submit" id="submit_event">Submit</button>
            <button class="btn btn-danger" type="reset"><i class="pg-close"></i> Clear</button>
          </div>
        </div>
        <!-- END PANEL -->
      </div>
      <!--<div class="col-md-6">
        <div class="row">
          <button class="btn btn-success" type="submit" id="submit_event">Submit</button>
          <button class="btn btn-default"><i class="pg-close"></i> Clear</button>
        </div>
      </div>-->
    </div>
  </div>
  </form>
  <!-- END CONTAINER FLUID -->
@stop
