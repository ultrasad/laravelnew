@extends('layouts.admin')
@section('page_title', 'Events Create')
@section('content')
  <!-- START CONTAINER FLUID -->
  <form class="events-form dropzone" id="my-awesome-dropzone-form" role="form" action="/events" enctype="multipart/form-data" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="container-fluid container-fixed-lg">
    <div class="row">
      <div class="col-md-12">
        <h3 class='page-title p-l-10'>เพิ่มข่าวโปรโมชั่น</h3>
        <span class="error-reponse">
          @include('errors.list')
        </span>
      </div>
      <div class="col-md-8">
        <!-- START PANEL -->
        <div class="panel panel-default">
          <div class="panel-body sm-p-t-20">
              <div class="form-group form-group-default required">
                <label>หัวข้อข่าว</label>
                <input type="text" name="title" class="form-control title" placeholder="โปรโมชั่น" required />
              </div>
              <div class="form-group form-group-default required">
                <label>URL SLUG (ภาษาอังกฤษเท่านั้น / สูงสุด 60 ตัวอักษร)</label>
                <input type="text" name="url_slug" class="form-control url_slug" placeholder="ex: promotion-my-brand-my-name-date-year" required />
              </div>
              <div class="row">
                <div class="col-md-6 col-xs-12">
                  <div class="form-group form-group-default input-group col-xs-12">
                    <label>วันที่เริ่ม</label>
                    <input type="text" name="start_date" class="form-control" placeholder="Pick a date" id="datepicker-component">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">
                  <div class="form-group form-group-default input-group col-xs-12">
                    <label>วันสิ้นสุด</label>
                    <input type="text" name="end_date" class="form-control" placeholder="Pick a date" id="datepicker-component2">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group form-group-default input-group">
                <label>รูปภาพหลัก</label>
                <input type="text" class="form-control" />
                <span class="input-group-addon btn-file">
                    <input type="file" name="image" class="form-control form-control-image" id="image" placeholder="รูปภาพ" readonly />
                    <i class="fa fa-picture-o icon-picture"></i>
                </span>
              </div>

              <!-- START PANEL -->
              <div class="form-group form-group-default panel-gallery"><label>รูปภาพ Gallery (ต้องเชื่อมต่อกับ Facebook Fanpage)</label></div>
              <div class="panel-body no-scroll no-padding dropzone-file-previews">
                <input type='hidden' name='base64data' id="base64data" />
                <div class="table table-striped files dropzone-previews dropzoner" id="previews">
                     <div id="template" class="file-row">
                       <div class="dz-default dz-message" data-dz-message><span>Drop files here to upload</span></div>
                     </div>
                 </div>
              </div>

              <div class="form-group form-group-default form-group-map">
                <label>สถาณที่จัดโปรโมชั่น</label>
                <input type="text" size="50" name="event_location" class="form-control" id="event_location" placeholder="กรอกข้อมูลสถาณที่เพื่อกำหนดตำแหน่ง" />
              </div>

              <div class="form-group">
                <div id="map_canvas" class="map-canvas"></div>
                <div class="row">
                  <input name="location_lat" type="hidden" id="location_lat" value="0" />
                  <input name="location_lon" type="hidden" id="location_lon" value="0" />
                  <input name="location_zoom" type="hidden" id="location_zoom" value="0" />
                </div>
              </div>

              <!-- END PANEL -->
              <div class="form-group form-group-default form-group-normal required">
                <label>Keyword (สูงสุด 20 คำ)</label>
                <input class="tagsinput custom-tag-input validate" id="tag_list" name="tag_list" type="text" value="" />
              </div>
              <div class="form-group form-group-default form-group-area required">
                <label>รายละเอียดแบบย่อ</label>
                <textarea class="form-control" name="brief" rows="3" required></textarea>
              </div>
              <div class="form-group">
                <label>รายละเอียด</label>
                <div class="tools">
                  <a class="collapse" href="javascript:;"></a>
                  <a class="config" data-toggle="modal" href="#grid-config"></a>
                  <a class="reload" href="javascript:;"></a>
                  <a class="remove" href="javascript:;"></a>
                </div>
                <div class="no-scroll">
                  <div class="summernote-wrapper">
                    <textarea class="input-block-level note-placeholder" id="summernote" name="description" class="summernote" rows="10"><div><br></div></textarea>
                  </div>
                </div>
              </div>

              <div class="form-group social-post-title">
                <h5><i class="fa fa-share-square-o fa-lg"></i> Post ไปยัง Social Network <input type="checkbox" name="social_post_switchery" class="js-check-change" data-init-plugin="switchery" data-size="small" data-color="primary" /></h5>
                <input name="social_post" class="js-check-change-field" type="hidden" value="N" />
              </div>

              <div class="social_group">
                <div class="form-group">
                  <label class="social-facebook-title">Facebook</label>
                  <!--<span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="fb1" id="checkbox2" />
                      <label class="label-master" for="checkbox2">Channel 2</label>
                    </div>
                  </span>
                  <span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="fb2" id="checkbox3">
                      <label class="label-master" for="checkbox3">One</label>
                    </div>
                  </span>-->
                  <textarea class="form-control fb_message" name="facebook_title" rows="3"></textarea>
                </div>

                <div class="form-group">
                  <label class="social-twitter-title">Twitter</label>
                  <!--<span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="tw1" id="checkbox4">
                      <label class="label-master" for="checkbox4">Ch8</label>
                    </div>
                  </span>
                  <span class="checkbox-inline">
                    <div class="checkbox check-warning">
                      <input type="checkbox" checked="checked" value="1" name="tw2" id="checkbox5">
                      <label class="label-master" for="checkbox5">Sabaidee</label>
                    </div>
                  </span>-->
                  <textarea class="form-control tw_message" name="twitter_title" rows="3"></textarea>
                </div>
              </div>
          </div>
        </div>
        <!-- END PANEL -->
      </div>
      <div class="col-md-4">
        <!-- START PANEL -->
        <div class="panel panel-default">

          <div class="row">
              <div class="col-sm-12 cs-brand">
                  <!--
                  <select name="brand" class="cs-select cs-skin-slide cs-select-brand validate">
                    @if($brands->count() > 1)
                    <option value="">กรุณาเลือกแบรนด์สินค้า</option>
                    @endif
                    @if($brands)
                      @foreach($brands as $id => $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                      @endforeach
                    @endif
                  </select>
                -->
                  <div class="form-group form-group-default form-group-normal form-group-cs-select2">
                    <select class="full-width cs-select2 validate" name="brand" data-init-plugin="select2">
                      @if($brands->count() > 1)
                      <option value="">กรุณาเลือกแบรนด์สินค้า</option>
                      @endif
                      @if($brands)
                        @foreach($brands as $id => $brand)
                          <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
              </div>
              <div class="brand-category" style="display: none">
                @foreach($brand_category as $id => $category)
                  <input type="text" name="category[]" class="brand-category" value="{{ $id }}" id="category_{{ $id }}" />
                @endforeach
              </div>
              <input type='hidden' id='brand_id' class='brand_id' name='brand_id' value='{{ ($brands->count() == 1)?$brands->first()->id:'' }}' />
          </div>

          <div class="panel-heading">
            <div class="panel-title">
              สาขาที่ร่วมรายการ
            </div>
          </div>
          <div class="panel-body">
            <div class="wizard-footer padding-5 bg-master-lightest master-checkbox-all check-branch-all" style="display: {{ (count($branch) > 0)?'':'none' }}">
              <div class="checkbox check-success">
                <input type="checkbox" checked="checked" name="branch_all" value="1" class="branch_all" id="branch_all">
                <label class="label-master" for="branch_all">ทุกสาขา</label>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="wizard-footer padding-5 branch_child">
              <div class="list">
                @if($branch)
                  @foreach($branch as $id => $branch)
                  <div class="checkbox check-warning">
                    <input type="checkbox" checked="checked" name="branch[]" class="branch" value="{{ $id }}" id="branch_{{ $branch->id }}">
                    <label for="branch_{{ $branch->id }}">{{ $branch->name }}</label>
                  </div>
                  @endforeach
                @endif
              </div>

              <div class="form-group new_branch_btn" style="display: {{ (count($branch) > 0)?'':'none' }}">
                  <a href="javascript: void(0);" title="เพิ่มสาขาใหม่" class="add_new_branch"><span class="new-branch"><i class="fs-14 pg-minus pg-plus"></i>เพิ่มสาขาใหม่</span></a>
              </div>

            </div>
          </div>

          <div class="panel-body new_branch_panel p-t-0" style="display: none;">
            <div class="form-group form-group-default form-group-map">
              <label>ชื่อสาขา</label>
              <input type="text" size="50" name="branch_name" class="form-control" id="branch_name" placeholder="ชื่อสาขา" />
            </div>

            <div class="form-group form-group-default form-group-area">
              <label>ข้อมูลสาขาแบบย่อ</label>
              <textarea class="form-control" name="branch_detail" id="branch_detail" rows="3"></textarea>
            </div>

            <div class="form-group form-group-default form-group-map">
              <label>ที่ตั้งสาขา</label>
              <input type="text" size="50" name="branch_location" class="form-control" id="branch_location" placeholder="กรอกข้อมูลสถาณที่เพื่อกำหนดตำแหน่ง" />
            </div>

            <div class="form-group">
              <div id="map_canvas_branch" class="map-canvas"></div>
              <div class="row">
                <input name="branch_location_lat" type="hidden" id="branch_location_lat" value="0" />
                <input name="branch_location_lon" type="hidden" id="branch_location_lon" value="0" />
                <input name="branch_location_zoom" type="hidden" id="branch_location_zoom" value="0" />
              </div>
            </div>

            <div class="wizard-footer padding-5 branch_child">
              <div class="form-group">
                  <button class="btn btn-primary btn-xs" type="button" id="add_branch">เพิ่มสาขา</button>
              </div>
            </div>
          </div>

        </div>
        <!-- END PANEL -->
        <!-- START PANEL -->
        <div class="panel panel-default master-checkbox-all">
          <div class="panel-heading">
            <div class="panel-title">
              <div class="checkbox check-danger">
                <input type="checkbox" checked="checked" class="published_check" name="published_now" value="{{ date('Y-m-d') }}" id="published_check">
                <label class="label-master" for="published_check">ขึ้นแสดงผลทันที</label>
              </div>
            </div>
          </div>
          <div class="panel-body published_set_time" style="display: none">
            <div class="form-group form-group-default input-group col-sm-12">
              <label>ตั้งเวลาขึ้นแสดง</label>
              <input type="text" name="published_at" class="form-control" placeholder="Pick a date" id="datepicker-component3">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>

          <div class="panel-body">
            <button class="btn btn-sm btn-success" type="submit" id="submit_event">Submit</button>
            <button class="btn btn-sm btn-danger"><i class="pg-close"></i> Clear</button>
          </div>
        </div>
        <!-- END PANEL -->
      </div>
    </div>
  </div>
  </form>
  <!-- END CONTAINER FLUID -->

  <div class="event_branch_row" style="display: none;">
    <div class="checkbox check-warning branch_row">
      <input type="checkbox" id="branch_x" value="" class="branch" name="branch[]" checked="checked"><label for="branch_x">สาขา</label>
    </div>
  </div>
@stop
