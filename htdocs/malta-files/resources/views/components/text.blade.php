<section class="content-text">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        @foreach($data as $paragraph)
          <p>{!! nl2br($paragraph) !!}</p>
        @endforeach
      </div>
    </div>
  </div>
</section>