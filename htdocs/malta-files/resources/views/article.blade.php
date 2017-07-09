<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>{{ $details['title'] }}</title>
    <meta name="description" content="">
    <meta name="author" content="TheBlackSea.eu">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Oxygen:300,400,700|Merriweather:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ env('APP_PATH') }}css/aos.min.css">
    <link rel="stylesheet" href="{{ env('APP_PATH') }}css/site.css?<?=time();?>">
    <link rel="icon" type="image/png" href="http://serenitymedia.ro/uploads/favicon.png">

    <meta property="og:title" content="{{ $details['title'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ $details['description'] }}" />
    <meta property="og:image" content="{{ env('APP_URL') . env('APP_PATH') . $details['fb_image'] }}" />
    <meta property="og:url" content="" />

</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=166042473905889";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <nav class="theblacksea">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 who">
                    <a href="http://theblacksea.eu" class="name">The Black Sea</a>
                    <span class="tagline">Diving deep into stories</span>
                </div>
                <div class="col-sm-6 links">
                    <a href="http://theblacksea.eu/?idT=86&idC=86">Blogs</a>
                    <a href="http://theblacksea.eu/?idT=88&idC=88">Stories</a>
                    <a href="http://theblacksea.eu/?idT=3&idC=3">About</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="share-links">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=full_url($_SERVER);?>">
            <img src="{{ env('APP_PATH') }}img/icons/icon-fb.svg" alt="Share on Facebook" />
        </a>
        <a href="mailto:?subject=&body=<?=full_url($_SERVER);?>">
            <img src="{{ env('APP_PATH') }}img/icons/icon-email.svg" alt="Share via E-mail" />
        </a>
        <a href="https://twitter.com/intent/tweet?original_referer=<?=urlencode(full_url($_SERVER));?>&ref_src=twsrc%5Etfw&text=<?=urlencode($details['title'])?>&tw_p=tweetbutton&url=<?=urlencode(full_url($_SERVER));?>">
            <img src="{{ env('APP_PATH') }}img/icons/icon-twitter.svg" alt="Share via Twitter" />
        </a>
    </section>

    @foreach($content as $section)
        @include('components/' . $section['type'], ['data' => $section['data']])
    @endforeach

    <section class="comments">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fb-comments" data-href="<?=full_url($_SERVER);?>" data-numposts="5" data-width="100%"></div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="{{ env('APP_PATH') }}js/aos.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
  </script>

  <!-- Piwik -->
  <script type="text/javascript">
    var _paq = _paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u="https://piwik.theblacksea.eu/";
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', '1']);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <noscript><p><img src="https://piwik.theblacksea.eu/piwik.php?idsite=1&rec=1" style="border:0;" alt="" /></p></noscript>
  <!-- End Piwik Code -->
</body>
</html>
