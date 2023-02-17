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
      @foreach($team as $t)
        <a href="#" class="slide card card-b card-gray">
          <div class="img-container">
              <img src="{{!empty($t->photo)?'/storage/images/'.$t->photo:'/img/default.png'}}" alt="{{$t->name}}" />
          </div>
          <h3 class="card-title">{{$t->name}}</h3>
          <p>{{$t->teaser}}</p>
        </a>
      @endforeach
    </div>
  </div>
</div>