
<div class="section-content">
  <div class="container" transition-parent="">
    <p>
      Molestie nec in mauris eget ac nisi enim aliquet. Arcu urna in nulla
      porttitor enim mauris odio. Aenean elementum vel nullam vestibulum
      ut tincidunt scelerisque faucibus habitant. Habitasse nec blandit
      diam pulvinar tempor. Ullamcorper pellentesque adipiscing id cursus
      amet.
    </p>
    <div class="grid grid-3 widget-list" transition-parent="">
      @foreach($portfolio as $p)
        <a href="/portfolio/{{$p->slug}}" class="slide card card-b card-gray">
          <div class="img-container">
            <img src="{{!empty($p->photo)?'/storage/images/'.$p->photo:'/img/default.png'}}" alt="{{$p->name}}" />
          </div>
          <h3 class="card-title">{{$p->name}}</h3>
          <p>{{$p->teaser}}</p>
          <p>
            <span href="/portfolio/{{$p->slug}}" class="btn btn-text">
              <span>Read more</span>
              <span icon="arrow-right-1"></span>
            </span>
          </p>
        </a>
      @endforeach
    </div>
  </div>
</div>