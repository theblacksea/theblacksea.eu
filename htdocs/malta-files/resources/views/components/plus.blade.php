<div class="plus">
  @foreach($data as $k => $paragraph)
    <p>
      @if($k == 0)
        <span class="plus-sign">&plus;</span>
      @endif
      {!! $paragraph !!}
    </p>
  @endforeach
</div>