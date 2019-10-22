@extends('layouts.document')
@section('page_title', 'โปรโมชั่นรอบๆตัวคุณ - รวม โปรโมชั่น ลดราคา Sale ชิงโชค discount คูปอง')
@section('content')
    <div class="map-controls">
      <div class="pull-left">
        <div class="btn-group btn-group-vertical" data-toggle="buttons-radio">
          <button id="map-user-location" class="btn btn-success btn-xs">สาขาที่ใกล้คุณที่สุด</button>
        </div>
      </div>
    </div>
    <div class="map-container full-width full-height">
      <div id="map_canvas" class="map-canvas map-full full-width full-height"></div>
    </div>
    <div class="row">
      <input name="location_branch_lat" type="hidden" id="location_branch_lat" value="{{ $lat }}">
      <input name="location_branch_lon" type="hidden" id="location_branch_lon" value="{{ $lon }}">
      <input name="location_lat" type="hidden" id="location_lat" value="0" />
      <input name="location_lon" type="hidden" id="location_lon" value="0" />
      <input name="location_zoom" type="hidden" id="location_zoom" value="0" />
    </div>
@stop
