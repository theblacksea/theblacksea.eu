<section class="content-image-half">
  <div class="container">
    <div class="image" data-aos="fade-right">
      <img src="img/photo/{{ $data['src'] }}" alt="" />
    </div>
    <div class="text {{ isset($data['position'])?$data['position']:'right' }}" data-aos="fade-left">
      @if(isset($data['text']['h1']))
        <h1>{!! $data['text']['h1'] !!}</h1>
      @endif
      @if(isset($data['text']['h2']))
        <h1>{!! $data['text']['h2'] !!}</h1>
      @endif
      @if(isset($data['text']['h3']))
        <h1>{!! $data['text']['h3'] !!}</h1>
      @endif
      @if(isset($data['text']['minus']))
        @include('components/minus', ['data' => $data['text']['minus']])
      @endif
      @if(isset($data['text']['plus']))
        @include('components/plus', ['data' => $data['text']['plus']])
      @endif
    </div>
  </div>
</section>