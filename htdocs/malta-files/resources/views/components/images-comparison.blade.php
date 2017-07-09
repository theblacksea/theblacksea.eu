<section class="content-images-comparison">
  <div class="container">
    <div class="row no-gutters">
      @foreach($data['images'] as $image)
        <div class="col-sm-6 image" style="background-image: url('img/photo/{{ $image }}');" data-aos="fade"></div>
      @endforeach
    </div>
    <div class="row no-gutters text">
      <div class="col-sm-6">
        @include('components/minus', ['data' => $data['text']['minus']])
      </div>
      <div class="col-sm-6">
        @include('components/plus', ['data' => $data['text']['plus']])
      </div>
    </div>
  </div>
</section>