@extends('layouts.frontend')

@section('content')
    
<div class="section-content title-content">
    <div class="container">
      <div class="desc-container">
        <p class="breadcrumb">
          <a href="/portfolio">Portfolio</a> | <strong>{{$portfolio->name}}</strong>
        </p>
        <h1>{{$portfolio->name}}</h1>
      </div>
    </div>
  </div>
  <div class="section-content">
    <div class="container" transition-parent>
      
      @if($portfolio->banner_photo !== null)
        <picture class="img-container">
          <source
            media="(min-width: 768px)"
            srcset="{{!empty($portfolio->banner_photo)?'/storage/images/'.$portfolio->banner_photo:'/img/default.png'}}"
          />
          <img src="{{!empty($portfolio->banner_photo)?'/storage/images/'.$portfolio->banner_photo:'/img/default.png'}}" alt="{{$portfolio->name}}" />
        </picture>
      @endif

      {!! $portfolio->content !!}

    </div>
  </div>


  @include('frontend.module.contact_us_banner') 
  
@endsection
