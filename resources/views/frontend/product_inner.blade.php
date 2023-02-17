@extends('layouts.frontend')

@section('content')
    
  <div class="section-content title-content">
    <div class="container">
      <div class="desc-container">
        <p class="breadcrumb">
          <a href="/products">Products</a> | <strong>{{$product->name}}</strong>
        </p>
        <h1>{{$product->name}}</h1>
      </div>
    </div>
  </div>
  <div class="section-content">
    <div class="container" transition-parent>

      @if($product->banner_photo !== null)
        <picture class="img-container">
          <source
            media="(min-width: 768px)"
            srcset="{{!empty($product->banner_photo)?'/storage/images/'.$product->banner_photo:'/img/default.png'}}"
          />
          <img src="{{!empty($product->banner_photo)?'/storage/images/'.$product->banner_photo:'/img/default.png'}}" alt="{{$product->name}}" />
        </picture>
      @endif

      {!! $product->content !!}

      <h3 class="flex-title">
        <span>Solutions</span>
      </h3>
      <div class="grid grid-3">
        @foreach($service as $s)
          <a href="/services/{{$s->slug}}" class="slide card card-b card-gray">
            <div class="img-container">
              <img src="{{!empty($s->photo)?'/storage/images/'.$s->photo:'/img/default.png'}}" alt="{{$s->name}}" />
            </div>
            <h4 class="card-title">{{$s->name}}</h4>
            <p>{{$s->teaser}}</p>
            <p>
              <span class="btn btn-text">
                <span>Read More</span>
                <span icon="arrow-right-1"></span>
              </span>
            </p>
          </a>
        @endforeach
      </div>
    </div>
  </div>

  @include('frontend.module.contact_us_banner') 

@endsection
