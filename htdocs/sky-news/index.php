<?php
include("parser.php");
?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>The Fix-Up: How Sky News broadcasts false content about east Europe</title>
    <meta name="description" content="Evidence that puts into question the truth and ethics of the UK satellite TV station’s major exclusives">
    <meta name="author" content="TheBlackSea.eu">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://fonts.googleapis.com/css?family=Oxygen:300,400,700|Merriweather:400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/aos.min.css">
    <link rel="stylesheet" href="css/site.css?<?=time();?>">
    <link rel="icon" type="image/png" href="http://serenitymedia.ro/uploads/favicon.png">

    <meta property="og:title" content="The Fix-Up: How Sky News broadcasts false content about east Europe" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Evidence that puts into question the truth and ethics of the UK satellite TV station’s major exclusives" />
    <meta property="og:image" content="http://theblacksea.eu/sky-news/img/photo/fb-image.jpg" />
    <meta property="og:url" content="http://theblacksea.eu/sky-news/" />

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

    <header>
        <div class="main-info">
            <h1 data-aos="fade"><span>The Fix-Up</span></h1>
            <h2 data-aos="fade"><span>How Sky News broadcasts false content about east Europe</span></h2>
            <h3 data-aos="fade"><span>By Michael Bird and Lina Vdovîi</span></h3>
            <h4 data-aos="fade"><span>16 March 2017</span></h4>
            <p data-aos="fade">
                <a href="#">
                    <img src="img/icons/arrow-down.svg" alt="Read" class="arrow" />
                </a>
            </p>
        </div>
    </header>

    <section class="share-links">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=full_url($_SERVER);?>">
            <img src="img/icons/icon-fb.svg" alt="Share on Facebook" />
        </a>
        <a href="mailto:?subject=The Fix-up: How Sky News broadcasts false content about east Europe&body=<?=full_url($_SERVER);?>">
            <img src="img/icons/icon-email.svg" alt="Share via E-mail" />
        </a>
        <a href="https://twitter.com/home?status=The Fix-up: How Sky News broadcasts false content about east Europe <?=full_url($_SERVER);?>">
            <img src="img/icons/icon-twitter.svg" alt="Share via Twitter" />
        </a>
    </section>

    <?php foreach($content as $section): ?>
        <?php component($section['type'], $section['data']); ?>
    <?php endforeach; ?>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-push-8">
                    <img src="img/icons/eye-camera-icon.svg" alt="" />
                </div>
                <div class="col-sm-8 col-sm-pull-4">
                    <p>The authors of this article are open to receive more similar examples of the practices detailed above from primary sources:</p>
                    <p>
                        Michael Bird: <a href="mailto:michaeljamesbird@gmail.com">michaeljamesbird@gmail.com</a><br>
                        Lina Vdovîi: <a href="mailto:linavdovii@gmail.com">linavdovii@gmail.com</a>
                    </p>
                    <p>Look and feel by Corina Dragomir and Victor Avasiloaei.</p>
                    <p>Screen grabs from Sky News reports</p>
                    <p>Project financed by an FoX grant from <a href="http://journalismfund.eu" target="_blank"><img src="img/journalismfundlogo.png" alt="Journalism Funds FoX Grant" class="journalismfund"></a></p>
                </div>
            </div>
        </div>
    </footer>

    <section class="comments">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fb-comments" data-href="http://theblacksea.eu/sky-news/" data-numposts="5" data-width="100%"></div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/aos.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
  </script>
    <script type="text/javascript">
      var _paq = _paq || [];
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.theblacksea.eu//";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', 1]);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
        g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
      })();



    </script>
    <noscript><p><img src="http://piwik.theblacksea.eu/piwik.php?idsite=1" style="border:0" alt=""/></p></noscript>
</body>
</html>