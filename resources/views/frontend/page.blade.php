@extends('layouts.frontend')

@section('content')
    
  {!! $page->content !!}

  @if($page->slug === 'the-team')
    @include('frontend.module.team') 
  @endif

  @if($page->slug === 'products')
    @include('frontend.module.product') 
  @endif

  @if($page->slug === 'news-and-awards')
    @include('frontend.module.news') 
  @endif

  @if($page->slug === 'portfolio')
    @include('frontend.module.portfolio') 
  @endif
  
  @if($page->slug === 'services')
    @include('frontend.module.service') 
  @endif


  @if($page->slug === 'contact-us')
    @include('frontend.module.contact_us') 
  @else
    @include('frontend.module.contact_us_banner') 
  @endif
  
@endsection
