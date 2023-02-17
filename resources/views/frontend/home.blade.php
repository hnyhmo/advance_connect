@extends('layouts.frontend')

@section('content')
    
  {!! $page->content !!}

  <div class="section-content content-centered">
    <div class="container" transition-parent>
      <p class="breadcrumb"><strong>Our Services</strong></p>
      <h2>
        We provide specialized services from the most trusted brand in the
        industry
      </h2>
      <p>
        Congue nunc at eleifend velit eget mi. Imperdiet eu sem vestibulum
        nunc varius egestas orci morbi.
      </p>
      <div class="grid grid-3 services-list widget-list" transition-parent>
        @foreach($products as $p)
          <a href="/products/{{$p->slug}}" class="img-container">
            <img src="{{!empty($p->photo)?'/storage/images/'.$p->photo:'/img/default.png'}}" alt="{{$p->name}}" />
            <h3>{{$p->name}}</h3>
          </a>
        @endforeach
        
      </div>
      <p>
        <a href="#" class="btn pri-btn">Know more about our services</a>
      </p>
    </div>
  </div>
  <div class="section-content content-centered">
    <div class="container" transition-parent>
      <p class="breadcrumb"><strong>Portfolio</strong></p>
      <h2>
        We have experience in effectively solving the problems of our
        clients
      </h2>
      <div class="slider portfolio-slider widget-list" transition-parent>
        @foreach($portfolio as $pf)
          <div class="slide card card-b card-gray">
            <div class="img-container">
              <img src="{{!empty($p->photo)?'/storage/images/'.$p->photo:'/img/default.png'}}" alt="{{$pf->name}}" />
            </div>
            <h3 class="card-title">
              {{$pf->name}}
            </h3>
            <p>
              {{$pf->teaser}}
            </p>
            <p>
              <a href="/portfolio/{{$pf->slug}}" class="btn btn-text">
                <span>Read more</span>
                <span icon="arrow-right-1"></span>
              </a>
            </p>
          </div>
        @endforeach
      </div>

      <h2>Some of our tusted brands</h2>
      <p>
        We are on a mission to address the housing backlog in the country by
        providing affordable quality mass housing.
      </p>

      <div class="grid brands-grid widget-list" transition-parent>
        @foreach($brand as $b)
          <div class="img-container">
            <img src="{{!empty($b->photo)?'/storage/images/'.$b->photo:'/img/default.png'}}" alt="{{$b->name}}" />
          </div>
        @endforeach
      </div>

      <p>
        <a href="#" class="btn btn-text">
          <span>View all brands</span>
          <span icon="arrow-right-1"></span>
        </a>
      </p>
    </div>
  </div>
  <!-- <div class="section-content contact-section">
    <div class="container">
      <div class="card">
        <div class="desc-container" transition-parent>
          <h2 class="card-title">
            Ultricies magna morbi ipsum nulla etiam phasellus eu non.
          </h2>
          <p>Ipsum ullamcorper tincidunt iaculis pharetra eget.</p>
          <p>
            <a class="btn">Contact us now!</a>
          </p>
        </div>
      </div>
    </div>
  </div> -->
  <div class="section-content contact-section">
    <div class="container">
      <form class="form grid grid-4 contact-form" transition-parent>
        <h2 class="full">Let's start a project together!</h2>
        <p class="full">
          <b>We help our clients achieve business goals</b>
        </p>
        <label class="form-group">
          <input type="text" placeholder="First Name*" />
        </label>
        <label class="form-group">
          <input type="text" placeholder="Last Name*" />
        </label>
        <label class="form-group">
          <input type="text" placeholder="Email*" />
        </label>
        <label class="form-group">
          <input type="text" placeholder="Contact no." />
        </label>
        <label class="form-group">
          <input type="text" placeholder="Company" />
        </label>
        <label class="form-group">
          <input type="text" placeholder="Job position" />
        </label>
        <label class="form-group full message">
          <textarea placeholder="Message*"></textarea>
        </label>

        <label class="form-group">
          <input type="submit" class="btn pri-btn" value="Submit" />
        </label>
        <label class="form-group"> [_captcha_] </label>
      </form>
    </div>
  </div>
    
@endsection
