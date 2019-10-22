@extends('layouts.document')
@section('page_title', 'ติดต่อเรา')
@section('content')

<div class="social-wrapper">
  <div class="social-element" data-pages="social">
    <div class="container-fluid container-fixed-lg sm-p-l-10 sm-p-r-10">
      <div class="m-b-5">&nbsp;</div>

      <!-- start form-->
      <div class="register-container form-contact full-height sm-p-t-30">
        <div class="container-sm-height full-height">
          <div class="row row-sm-height">
            <div class="col-sm-12 col-sm-height col-middle">
              <h3>ติดต่อเรา</h3>
              <p><small>65/3 Soi Vibhavadi-Rangsit20, Bangkok, Thailand 10900.</small></p>
              @if($errors->any())
                 <ul class="alert alert-danger">
                   @foreach($errors->all() as $error)
                     <li>{{$error}}</li>
                   @endforeach
                 </ul>
               @endif
              <form id="form-contact" class="p-t-15 form-contact" role="form" method="POST" role="form" action="/contact">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row clearfix">
                  <div class="col-sm-12">
                    <div class="form-group form-group-default required form-group-default-selectFx">
                      <label>หัวข้อที่ต้องการติดต่อ</label>
                      <select class="cs-select cs-select-contact cs-skin-slide cs-transparent form-control" name="topic" data-init-plugin="cs-select">
                        <option value="ซื้อโฆษณา">ซื้อโฆษณา</option>
                        <option value="ขอเข้าร่วมเป็น Brand และเพิ่มข่าวด้วยตัวเอง">ขอเข้าร่วมเป็น Brand และเพิ่มข่าวด้วยตัวเอง</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group form-group-default">
                      <label>ชื่อ</label>
                      <input type="text" name="fname" placeholder="ชื่อ" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group form-group-default">
                      <label>นามสกุล</label>
                      <input type="text" name="lname" placeholder="นามสกุล" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group form-group-default">
                      <label>อีเมล</label>
                      <input type="email" name="email" placeholder="อีเมล" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group form-group-default">
                      <label>เบอร์โทร</label>
                      <input type="text" name="phone" placeholder="เบอร์โทร" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group form-group-default">
                      <label>ข้อความ</label>
                      <textarea placeholder="ข้อความ" id="message" class="form-control contact-area" aria-invalid="false"></textarea>
                    </div>
                  </div>
                </div>

                  <div class="cols-sm-12">
                      <div class="recaptchatable" data-size="compact">{!! app('captcha')->display(); !!}</div>
                  </div>

                <button class="btn btn-primary btn-cons m-t-10" type="submit">ส่งข้อความ</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- end form -->
    </div>
    <!-- END CONTAINER FLUID -->
  </div>
  <!-- /container -->
</div>
@stop
