<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if(isset($data['p']))
                    @foreach($data['p'] as $paragraph)
                      <p>{!! nl2br($paragraph) !!}</p>
                    @endforeach
                @endif
                @if(isset($data['language']) && $data['language'] == 'tr')
                    <p>
                        Eğer bu haberde yazanlarla ilgili daha fazla bilgi sahibiyseniz bize yazın <a href="mailto:rcij@riseup.net">rcij@riseup.net</a> (pgp: 0x8234F8D4A624D9F4).
                    </p>
                    <p>
                        Bu makale journalismfund.eu’nun desteğiyle hazırlanmıştır.
                        <a href="http://journalismfund.eu" target="_blank"><img src="{{ env('APP_PATH') }}img/journalismfundlogo.png" alt="Journalism Funds FoX Grant" class="journalismfund"></a>
                    </p>
                @else
                    <p>
                        If you have more information on this story please send an email to <a href="mailto:rcij@riseup.net">rcij@riseup.net</a> (pgp: 0x8234F8D4A624D9F4).
                    </p>
                    <p>
                        This article was developed with the support of
                        <a href="http://journalismfund.eu" target="_blank"><img src="{{ env('APP_PATH') }}img/journalismfundlogo.png" alt="Journalism Funds FoX Grant" class="journalismfund"></a>
                    </p>
                @endif
                </p>
            </div>
        </div>
    </div>
</footer>