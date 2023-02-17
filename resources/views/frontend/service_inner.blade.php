@extends('layouts.frontend')

@section('content')
    
  <div class="section-content title-content">
    <div class="container">
      <div class="desc-container">
        <p class="breadcrumb">
          <a href="/services">Services</a> | <strong>{{$service->name}}</strong>
        </p>
        <h1>{{$service->name}}</h1>
      </div>
    </div>
  </div>
  <div class="section-content">
    <div class="container" transition-parent>
      
      @if($service->banner_photo !== null)
          <picture class="img-container">
            <source
              media="(min-width: 768px)"
              srcset="{{!empty($service->banner_photo)?'/storage/images/'.$service->banner_photo:'/img/default.png'}}"
            />
            <img src="{{!empty($service->banner_photo)?'/storage/images/'.$service->banner_photo:'/img/default.png'}}" alt="{{$service->name}}" />
          </picture>
        @endif
        
      {!! $service->content !!}

    </div>
  </div>

  @include('frontend.module.contact_us_banner') 

@endsection
