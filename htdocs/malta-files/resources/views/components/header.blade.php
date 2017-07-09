<header style="background-image: url('{{ env('APP_PATH') }}img/articles/{{ $data['image'] }}')">
    <div class="main-info">
        <h1 data-aos="fade"><span>{!! $data['h1'] !!}</span></h1>
        @if(isset($data['h2']))
            <h2 data-aos="fade"><span>{!! $data['h2'] !!}</span></h2>
        @endif
        @if(isset($data['h3']))
            <h3 data-aos="fade"><span>{!! $data['h3'] !!}</span></h3>
        @endif
        @if(isset($data['h4']))
            <h4 data-aos="fade"><span>{!! $data['h4'] !!}</span></h4>
        @endif
        <p data-aos="fade">
            <a href="#">
                <img src="{!! env('APP_PATH') !!}img/icons/arrow-down.svg" alt="Read" class="arrow" />
            </a>
        </p>
    </div>
</header>