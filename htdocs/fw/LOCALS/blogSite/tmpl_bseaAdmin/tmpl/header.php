
<?php

$title = ($core->siteTitle ?: '').' '.SITE_NAME;
?>
<title><?php echo $title; ?></title>
<meta property="og:title" content="<?php echo $title; ?>"/>

<link rel="shortcut icon" href="http://serenitymedia.ro/uploads/favicon.png" type="image/x-icon" />
<style type="text/css">
  body {
    padding-bottom: 40px;
  }
  .sidebar-nav {
    padding: 9px 0;
  }
</style>