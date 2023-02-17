
<div class="section-content">
  <div class="container" transition-parent="">
    @if($featured_news)
      <a href="/news-and-awards/{{$featured_news->slug}}" class="card card-gray no-padding">
        <div class="img-container">
          <img src="{{!empty($featured_news->photo)?'/storage/images/'.$featured_news->photo:'/img/default.png'}}" alt="{{$featured_news->name}}" />
        </div>
        <div class="desc-container">
          <h2 class="card-title">{{$featured_news->name}}</h2>
          <p><small>{{date('F d, Y', strtotime($featured_news->date))}}</small></p>
          <p>
            {{$featured_news->teaser}}
          </p>
          <p>
            <span class="btn btn-text">
              <span>Read More</span>
              <span icon="arrow-right-1"></span>
            </span>
          </p>
        </div>
      </a>
    @endif
    <h3 class="flex-title">
      <span>Latest news &amp; awards</span>
    </h3>
    <div class="grid grid-3 widget-list" transition-parent="">
      @foreach($news as $n)
        <div class="article-item">
          <h3 class="article-title">
            <a href="/news-and-awards/{{$featured_news->slug}}">{{$n->name}}</a>
          </h3>
          <p class="date">
            <small>{{date('F d, Y', strtotime($n->date))}}</small>
            @if($n->type === 'award')
              <small class="tag news">News</small>
            @else
              <small class="tag awards">Awards</small>
            @endif
          </p>
          <p>
            {{$n->teaser}}
          </p>
          <p>
            <a href="/news-and-awards/{{$featured_news->slug}}" class="btn btn-text">
              <span>Read More</span>
              <span icon="arrow-right-1"></span>
            </a>
          </p>
        </div>
      @endforeach
    </div>
    {!! $news->links() !!}
  </div>
</div>