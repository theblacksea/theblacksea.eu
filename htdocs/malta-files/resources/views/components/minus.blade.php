@foreach($data as $minus)
  <div class="minus">
    @foreach($minus as $k => $paragraph)
      <p>
        @if($k == 0)
          <span class="minus-dash">&mdash;</span>
        @endif
        {!! $paragraph !!}
      </p>
    @endforeach
  </div>
@endforeach