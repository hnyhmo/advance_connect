@extends('layouts.frontend')

@section('content')
  <div class="section-content title-content text-center">
    <div class="container">
      <div class="desc-container">
        <p class="breadcrumb">
          <a href="/news-and-awards">News and Awards</a>
        </p>

        <p>
        @if($news->type === 'award')
          <small class="tag news">News</small>
        @else
          <small class="tag awards">Awards</small>
        @endif
        </p>
        <h1>{{$news->name}}</h1>
        <p class="date">
          <small>{{date('F d, Y', strtotime($news->date))}}</small>
        </p>
      </div>
    </div>
  </div>
  <div class="section-content article-content">
    <div class="container" transition-parent>
      @if($news->banner_photo !== null)
        <picture class="img-container">
          <source
            media="(min-width: 768px)"
            srcset="{{!empty($news->banner_photo)?'/storage/images/'.$news->banner_photo:'/img/default.png'}}"
          />
          <img src="{{!empty($news->banner_photo)?'/storage/images/'.$news->banner_photo:'/img/default.png'}}" alt="{{$news->name}}" />
        </picture>
      @endif
      {!! $news->content !!}
    </div>
  </div>

  @include('frontend.module.contact_us_banner') 
  
@endsection
