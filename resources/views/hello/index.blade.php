@extends('layouts.main')
@section('page_title', 'Hello Page')

<!-- <img src='{{url('https://www.zipeventapp.com/api/v3/Event/Cover?id=8A82051E-519F-415E-90DA-072D71DA5504.png')}}' /> -->
<img src="{{asset('img/stock-photo-120916649.jpg')}}" />

@section('content')
  <h1>{!!$title!!}</h> <!--non escaped-->
  <p>{{$subtitle}}</p>
  <!-- @{{ Blade will not process this }} -->
  {{-- Blade Comment --}}

  @if(count($record) === 1)
    I have one record!
  @elseif(count($record) > 1)
    I have {{count($record)}} records!
  @else
    I have no record!
  @endif

@stop


@forelse($users as $user)
  <p>This is user {{$user->name}}</p>
@empty
  <p>No User!</p>
@endforelse

<!-- Unless, if not-->
<!--
@unless(Auth::check())
  You are not sign in.
@endunless

@for($i=0; $i<10; $i++)
<li>The current value is {{$i}}</li>
@endfor
-->
