<!-- BEGIN SIDEBPANEL-->
<nav class="page-sidebar" data-pages="sidebar">
  <!-- BEGIN SIDEBAR MENU HEADER-->
  <div class="sidebar-header">
    <img src="{{ URL::asset('assets/img/logo_white.png') }}" alt="logo" class="brand" data-src="{{ URL::asset('assets/img/logo_white.png') }}" data-src-retina="{{ URL::asset('assets/img/logo_white_2x.png') }}" width="78" height="22">
  </div>

  <!-- END SIDEBAR MENU HEADER-->
  <!-- START SIDEBAR MENU -->
  <div class="sidebar-menu">
    <!-- BEGIN SIDEBAR MENU ITEMS-->
    <ul class="menu-items">
      <li class="m-t-30">
        <a href="{{ url('/admin/setting') }}" class="detailed" title="ตั้งค่าทั่วไป">
          <span class="title">ตั้งค่าทั่วไป</span>
        </a>
        <span class="icon-thumbnail icon-category">
          <i class="fa fa-gear" aria-hidden="true"></i>
        </span>
      </li>
      <li class="">
        <a href="{{ url('/admin') }}" class="detailed" title="โปรโมชั่นทั้งหมด">
          <span class="title">โปรโมชั่นทั้งหมด</span>
        </a>
        <span class="icon-thumbnail icon-category bg-success">
          <i class="fa fa-heart" aria-hidden="true"></i>
        </span>
      </li>
      <li class="">
        <a href="{{ url('/events/create') }}" class="detailed" title="สร้างโปรโมชั่นใหม่">
          <span class="title">สร้างโปรโมชั่นใหม่</span>
        </a>
        <span class="icon-thumbnail icon-category">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </span>
      </li>
      @if($brands->count() > 1)
      <li class="">
        <a href="{{ url('/brand/lists') }}" class="detailed" title="แบรนด์ทั้งหมด">
          <span class="title">แบรนด์ทั้งหมด</span>
        </a>
        <span class="icon-thumbnail icon-category">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </span>
      </li>
      @elseif($brands->count() == 1)
      <li class="">
        <a href="{{ url('/brand/'.$brands->first()->id.'/edit/') }}" class="detailed" title="แก้ไขข้อมูลแบรนด์">
          <span class="title">แก้ไขข้อมูลแบรนด์</span>
        </a>
        <span class="icon-thumbnail icon-category">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </span>
      </li>
      @endif
      @if($role_id < 4)
      <li class="">
        <a href="{{ url('/brand/register') }}" class="detailed" title="สร้างแบรนด์ใหม่">
          <span class="title">สร้างแบรนด์ใหม่</span>
        </a>
        <span class="icon-thumbnail icon-category">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
        </span>
      </li>
      @endif
      {{--
      @forelse($brands as $brand)
      <li class="">
        <a href="{{ url('/brand/'.$brand->id.'/edit') }}" class="detailed" title="แก้ไขข้อมูลแบรนด์ {{ $brand->name }}">
          <span class="title">แก้ไขแบรนด์ {{ $brand->name }}</span>
        </a>
        <span class="icon-thumbnail icon-category">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </span>
      </li>
      @empty
      @endforelse
      --}}
    </ul>
    <div class="clearfix"></div>
  </div>
  <!-- END SIDEBAR MENU -->
</nav>
<!-- END SIDEBAR -->
<!-- END SIDEBPANEL-->
