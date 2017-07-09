<section class="content-image-full">
  <div class="image" style="background-image: url('{{ env('APP_PATH') .'img/articles/'. $data['src'] }}');" data-aos="fade" data-aos-duration="800"></div>
  @if(isset($data['text']))
    <div class="text {{ isset($data['position'])?$data['position']:'right' }}" data-aos="fade" data-aos-duration="1200">
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
      @if(isset($data['text']['p']))
        @foreach($data['text']['p'] as $paragraph)
          <p>{{ $paragraph }}</p>
        @endforeach
      @endif
    </div>
  @endif
</section>