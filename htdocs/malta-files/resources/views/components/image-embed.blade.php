<section class="content-image-embed {{ isset($data['class']) ? $data['class'] : '' }}">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="image">
        @if(isset($data['clickable']) && $data['clickable'])
          <a href="{{ env('APP_PATH') .'img/articles/'. $data['src'] }}">
        @endif
            <img src="{{ env('APP_PATH') .'img/articles/'. $data['src'] }}" alt="" {{ isset($data['class']) ? 'class="' . $data['class'] .'"' : '' }} />
        @if(isset($data['clickable']) && $data['clickable'])
          </a>
        @endif
        </div>
        @if(isset($data['caption']))
          <div class="caption">
            <p>{!! $data['caption'] !!}</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>