@extends('layouts.app')

@include('includes.header_login')
@section('content')
<!-- START Login Background Pic Wrapper-->
<div class="bg-pic">
  <!-- START Background Pic-->
  <img src="{{ URL::asset('assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg') }}" data-src="{{ URL::asset('assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg') }}" data-src-retina="{{ URL::asset('assets/img/demo/new-york-city-buildings-sunrise-morning-hd-wallpaper.jpg') }}" alt="" class="lazy">
  <!-- END Background Pic-->
  <!-- START Background Caption-->
  <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
    <h2 class="semi-bold text-white">
    Pages make it easy to enjoy what matters the most in the life</h2>
    <p class="small">
      images Displayed are solely for representation purposes only, All work copyright of respective owner, otherwise © 2013-2014 REVOX.
    </p>
  </div>
  <!-- END Background Caption-->
</div>
<!-- END Login Background Pic Wrapper-->
<!-- START Login Right Container-->
<div class="login-container bg-white">
  <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-30 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
    <!--<img src="{{ URL::asset('assets/img/logo.png') }}" alt="logo" data-src="{{ URL::asset('assets/img/logo.png') }}" data-src-retina="{{ URL::asset('assets/img/logo_2x.png') }}" width="78" height="22">-->
    <p class="p-t-35">Sign into your pages account</p>
    <!-- START Login Form -->
    <form id="form-login" class="p-t-15" role="form" method="POST" action="{{ route('login') }}">
      @csrf
      
      <!-- START Form Control-->
      <div class="form-group form-group-default">
        <label>Login</label>
        <div class="controls">

          <input id="login" type="text"
               placeholder="User Name"
               class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
               name="username" value="{{ old('username') ?: old('email') }}" required autofocus>
 
              @if ($errors->has('username') || $errors->has('email'))
                  <span class="invalid-feedback">
                      <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                  </span>
              @endif

        </div>
      </div>
      <!-- END Form Control-->
      <!-- START Form Control-->
      <div class="form-group form-group-default">
        <label>Password</label>
        <div class="controls">
          <input type="password" class="form-control" name="password" placeholder="Credentials" required>
          @if ($errors->has('password'))
              <label id="username-error" class="error" for="username">{{ $errors->first('password') }}</label>
          @endif
        </div>
      </div>
      <!-- START Form Control-->
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6 no-padding">
            <div class="checkbox ">
              <input type="checkbox" name="remember" id="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <!--
          <div class="col-md-6 text-right">
            <a href="#" class="text-info small">Help? Contact Support</a>
          </div>
          -->
        </div>
      </div>
      <!-- END Form Control-->
      <button class="btn btn-primary btn-cons m-t-10" type="submit">Sign in</button>
    </form>
    <!--END Login Form-->
    <div class="pull-bottom sm-pull-bottom">
      <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
        <!--<div class="col-sm-3 col-md-2 no-padding">
          <img alt="" class="m-t-5" data-src="{{ URL::asset('assets/img/demo/pages_icon.png') }}" data-src-retina="{{ URL::asset('assets/img/demo/pages_icon_2x.png') }}" height="60" src="{{ URL::asset('assets/img/demo/pages_icon.png') }}" width="60">
        </div>-->
        <div class="col-sm-9 no-padding m-t-10">
          <p>
            <small>
            Create a pages account. If you have a facebook account, log into it for this
            process. Sign in with <a href="#" class="text-info">Facebook</a> or
            <a href="#" class="text-info">Google</a>
          </small>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END Login Right Container-->
@endsection
