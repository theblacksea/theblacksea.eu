<?php
/*======================================================================*\
|| #################################################################### ||
|| # Youjoomla LLC - YJ- Licence Number 1179MU624
|| # Licensed to - Dana Connell
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2006-2009 Youjoomla LLC. All Rights Reserved.           ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- THIS IS NOT FREE SOFTWARE ---------------- #      ||
|| # http://www.youjoomla.com | http://www.youjoomla.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/


# EDITING NOTES :   ALL CODE BLOCKS ARE COMENTED , ALL PHP CONDITIONS BEFOR AND AFTER THE 
#  COMMENT ARE TO BE MOVED WITH THE BLOCK IF YOU ARE EDITING LAYOUTS
#  CSS MAIN LAYOUT IS IN LAYOUT.CSS  STARTING WITH 
# WIDTHS OF THE CODEBLOCKS ARE IN SETTINGS.PHP NAMED SAME AS DIVS USED

defined( '_JEXEC' ) or die( 'Restricted index access' );

define( 'TEMPLATEPATH', dirname(__FILE__) );
require( TEMPLATEPATH.DS."settings.php");

$langu =& JFactory::getLanguage();
$lang = $langu->getTag();
$id = JRequest::getVar('id');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<?php if($lang == "ru-RU"){ ?>
   <style type="text/css">
#horiznav a{
padding:0px 0px 0px 8px !important;
}
#horiznav li{
padding:0px 10px 0px 0px !important;
}
.contentheading, .contentheading a:link, .contentheading a:visited {
text-transform: none !important;
}
</style>
<?php } ?>
<?php
echo '<script type="text/javascript" src="'.$yj_site.'/src/jquery-1.10.1.min.js"></script>';
echo '<script type="text/javascript" src="'.$yj_site.'/src/js.js"></script>';

if($id == "2351:european-parliament-directive-cracks-down-on-criminal-assets"){
echo "<script type='text/javascript' src='https://public.tableausoftware.com/javascripts/api/viz_v1.js'></script>";
}
?>

<script type="text/javascript">
  $.noConflict();
</script>


<jdoc:include type="head" />
<?php $this->setGenerator('kameni@yahoo.com'); ?>

<?php JHTML::_('behavior.mootools'); ?>

<link href="<?php echo $yj_site ?>/css/template.<?php echo $cssextens; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo $yj_site ?>/css/<?php echo $css_file; ?>.<?php echo $cssextens; ?>" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="<?php echo $yj_site ?>/favicon.ico" />
<?php require( TEMPLATEPATH.DS."head.php");?>
</head>
<?php
if($id == "1527"){
header("Location: http://www.reportingproject.net/kotor_konnection/");
}

?>
<body id="<?php echo $body_color ?>">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- top pannel -->
<?php if ($top_panel == 1){ ?>
<div id="toppanel">
   <div id="toppanel_in" style="font-size:10px; width:<?php echo $css_width; ?>;">
   	<p class="ja-day">
	  <?php
	  
		echo "<span class=\"day\">".strftime("%A")."</span>";
		echo "<span class=\"date\">, ".strftime("%b")." ".date ('d')."";
        if($lang != "ru-RU"){
		echo date ('S');
		}
		echo "</span>";
	  ?>
	</p>

	<p class="ja-updatetime"><span><?php
	if($lang != "ru-RU"){
	echo "Last update:";
	} else {
    echo "Последнее обновление:";
	}
	?></span><em><jdoc:include type="modules" name="update" style="raw" /></em></p>

     <!-- site tools --><?php if ( $showfont== 1 || $showwidth== 1 || $showcolor== 1 ){ ?>
                <div id="tools"><?php require( TEMPLATEPATH.DS."tools.php"); ?></div><?php } ?><!-- end tools -->
   
 
<?php if ($this->countModules('inset') || $show_register == 1 || $show_about_link == 1){ ?><!-- registration and login -->
<div id="topholder">
     <div id="toplinks">
        <div id="linkem">
		<?php if($this->countModules('headlines')) : ?>
		<div class="zadnjea">
		<?php if($lang == "ru-RU"){
		?> Заголовки: <?php
        } else { ?>
		Headlines:
		<?php }?></div><div class="zadnje"><jdoc:include type="modules" name="headlines" /></div>
	<?php endif; ?>
        <?php if ($this->countModules('inset')){

		/*
		>
        
		
		<a href="javascript:;" onclick="this.blur();showThem('inset');return false;" id="showHideLogin">
		< php if($lang == "ru-RU"){
		> Войти <php
        } else { >
		Login
		<?php }></a><php } >
        <php if ($show_register == 1){ >
        <a href="javascript:;" onclick="this.blur();showThem('regbox');return false;" id="showHideRegbox">
		<php if($lang == "ru-RU"){
		> Зарегистрироваться <php
        } else { >		
		Register
		<php }>
		</a><php } >
*/
		}
        if ($show_about_link == 1){ ?>
        <a href="<?php echo $about_link ?>" id="about">
		<?php if($lang == "ru-RU"){
		?> О проекте OCCRP <?php
        } else { ?>	
		About us
		<?php }?></a><?php } ?>
		<a href="javascript:;" onclick="this.blur();showThem('regbox');return false;" id="showHideRegbox"></a>
       </div>
    </div>
    
     <?php if ($this->countModules('inset')){ ?><!-- login -->
       <div id="inset" style="display:none;">
       <jdoc:include type="modules" name="inset" style="yjsquare" />
       </div><?php } ?>


       <?php if ($show_register == 1){ ?><!-- registration  -->
        <div id="regbox"  style="display:none;">
          <?php include TEMPLATEPATH.DS."register.php";?>
       </div><?php } ?>


</div>
<!-- end registration and login --><?php } ?>


   </div>
</div>
<?php } ?>
<!-- end top pannel -->

    <div id="<?php if($lang == "ru-RU"){
	echo "centertop_ru";
	} else {
	echo "centertop"; } ?>" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">


<!-- notices -->
<?php if ($ie6notice == 1){ ?>
<!--[if lte IE 6]>
<p class="clip" style="text-align:center" >Hello visitor.You are using IE6 , an outdated version of Internet Explorer. Please consider upgrading. Click <a href="http://www.webstandards.org/action/previous-campaigns/buc/" target="_blank" >here</a> for more info .</p>
<![endif]-->
<?php } ?>



<!--header-->
<div id="header">
<div id="logo" class="png">

<div id="tags"><h1>
<a href="index.php" title="<?php echo $tags?>"><?php echo $seo ?></a>
</h1></div><!-- end tags -->

</div><!-- end logo -->
<div class="awards"><img class="award" id="r2" src="/occrp/images/awards/1.png"></div>
<div class="partneri"><jdoc:include type="modules" name="partneri" /></div>
<?php if ($this->countModules('banner')) {?>
<div id="banner" style="width:<?php echo $bannerwidth; ?>;">
<jdoc:include type="modules" name="banner" style="raw" />
</div><!-- end banner -->
<?php } ?>

</div><!-- end header -->


<!--top menu-->
<div id="<?php echo $topmenuclass ?>" style="font-size:<?php echo $css_font; ?>;">
  <div id="<?php if($lang != "ru-RU"){
  echo "horiznav";
  } else {
	  echo "horiznav";
  } ?>">
	<?php echo $topmenu; ?>
</div>
</div><!-- end top menu -->

</div><!-- end centartop-->

<?php if ($this->countModules('user1') || $this->countModules('user2') || $this->countModules('user3')) {?><!-- user 1 2 3 -->
<div id="advert1">
     <div id="advert1_in"  style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
           <!-- slider -->
<div id="slideshow">
<?php 


$nav = 0;
if ($this->countModules('user1')) $nav++;
if ($this->countModules('user2')) $nav++;
if ($this->countModules('user3')) $nav++;
if ( $nav > 1 ) {

 ?>
<a class="slidep" onclick='javascript: slidebox.prev(type_slider);'>Prev</a>
<a class="sliden" onclick='javascript: slidebox.next(type_slider);'>Next</a>
<?php } ?>
<div id="SlideBox" class="SlideBox"  style="width:<?php echo $slidebox_width ?>;">
	<div  style="width:<?php echo $SlideBox_f ?>;">
    <?php if ($this->countModules('user1')) { ?>
		<div class="SlideBox"  style="width:<?php echo $slidebox_width ?>;">
        <div class="slideuser" style="width:<?php echo $SlideBox_m ?>;">
			<jdoc:include type="modules" name="user1" style="yjsquare" /></div>
		</div><?php } ?>
        
        <?php if ($this->countModules('user2')) { ?>
		<div class="SlideBox"  style="width:<?php echo $slidebox_width ?>;">
        <div class="slideuser" style="width:<?php echo $SlideBox_m ?>;">
			<jdoc:include type="modules" name="user2" style="yjsquare" /></div>
		</div><?php } ?>
        
        <?php if ($this->countModules('user3')) { ?>
		 <div class="SlideBox"  style="width:<?php echo $slidebox_width ?>;">
          <div class="slideuser" style="width:<?php echo $SlideBox_m ?>;">
			<jdoc:include type="modules" name="user3" style="yjsquare" /></div>
		 </div><?php } ?>
        

</div>

<script type='text/javascript'>
var  slidebox = new SimpleSlide("SlideBox",{type: "<?php echo $slide_type ?>", direction: "<?php echo $slide_pageload ?>", auto: "loop", time: <?php echo $slide_time?>, duration: <?php echo $slide_duration ?>});
var type_slider='<?php echo $slide_type ?>';
<?php if ($slide_pageload  == 'forward') { ?>
$('SlideBox').addEvent('mouseenter', function(){slidebox.pause();});
$('SlideBox').addEvent('mouseleave', function(){slidebox.run();});
<?php } ?>
</script>
<!-- end slider -->
</div>
</div>
</div>
</div>
<!-- end 1 2 3  --><?php } ?>

  <?php if ($this->countModules('user4') || $this->countModules('user5') || $this->countModules('user6')) {?><!-- top mods -->

<div id="topmods">
  <div id="topmods_in"  style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
  <?php if ($this->countModules('user4')) {?>
   <div id="user4" style="width:<?php echo $topswidth ?>;"><jdoc:include type="modules" name="user4" style="yjsquare" /></div><?php } ?>
    <?php if ($this->countModules('user5')) {?>
   <div id="user5" style="width:<?php echo $topswidth ?>;"><jdoc:include type="modules" name="user5" style="yjsquare" /></div><?php } ?>
     <?php if ($this->countModules('user6')) {?>
   <div id="user6" style="width:<?php echo $topswidth ?>;"><jdoc:include type="modules" name="user6" style="yjsquare" /></div><?php } ?>
  
  
  </div>
</div>

<!-- end topmods --><?php } ?>


<!-- BOTTOM PART OF THE SITE LAYOUT -->
<div id="centerbottom" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
<div id="<?php echo $wrap?>">
<div id="<?php echo $insidewrap ?>">





<!--MAIN LAYOUT HOLDER -->
<div id="holder">

<!-- messages -->
<jdoc:include type="message" />
<!-- end messages -->





<?php if ($this->countModules('left')) { ?>
<!-- left block -->
<div id="leftblock" style="width:<?php echo $leftblock ?>;">
<div class="inside">
<jdoc:include type="modules" name="left" style="yjsquare" />
</div>
</div>
<!-- end left block -->
<?php } ?>




<!-- MID BLOCK WITH TOP AND BOTTOM MODULE POSITION -->
<div id="midblock" style="width:<?php echo $midblock ?>;">
<div class="insidem">

<?php if ($this->countModules('top')) { ?>
<!-- top module-->
<div id="topmodule"><div class="vrh">
<?php /*
<div class="vrha">
<jdoc:include type="modules" name="ccwatch" style="yjsquare" /> 
</div>
*/
?>
<div class="vrhb">
<jdoc:include type="modules" name="top" style="yjsquare" /> 
</div></div></div>
<!-- end top module-->
<?php } ?>
<!-- pathway -->

<?php if ($this->countModules('breadcrumb')) { ?> 
<div id="pathway">
You are here:&nbsp;&nbsp;<jdoc:include type="modules" name="breadcrumb" /></div>
<?php } ?>

<!-- end pathway -->
<!-- component -->
<jdoc:include type="component"  />
<?php
$menu = & JSite::getMenu();
if ($menu->getActive() == $menu->getDefault()) {
if($lang != "ru-RU"){
echo'<br /><br /><div style="float: left; width: 80px; margin: 0; padding:20px 0 0 0;"><strong>Member of</strong></div><div style="float: left; width: 400px;"><a href="http://www.gijn.org/" target="_blank"><img src="images/gijn.png" alt="GIJN"></a></div>';
} else {
echo'<br /><br /><div style="float: left; width: 80px; margin: 0; padding:20px 0 0 0;"><strong>Участник</strong></div><div style="float: left; width: 400px;"><a href="http://www.gijn.org/" target="_blank"><img src="images/gijn.png" alt="GIJN"></a></div>';
}
}
?>
<!-- end component -->


<?php if ($this->countModules('bottom')) { ?>
<!-- bottom module position -->
<div id="bottommodule">
<jdoc:include type="modules" name="bottom" style="yjsquare" />
</div>
<!-- end module position -->
<?php } ?>



</div><!-- end mid block insidem class -->
</div><!-- end mid block div -->
<!-- END MID BLOCK -->






<?php if ($this->countModules('right')) { ?>
<!-- right block -->
<div id="rightblock" style="width:<?php echo $rightblock ?>;">
<div class="inside">
<?php
	if(JRequest::getVar('view') == 'article'){
	?>
<jdoc:include type="modules" name="top-right" style="yjsquare" />
<?php } ?>
<?php if($lang != "ru-RU"){ ?>
<jdoc:include type="modules" name="ccwatch" style="yjsquare" /> 
<?php } ?>
<jdoc:include type="modules" name="right" style="yjsquare" />
<?php if($lang != "ru-RU"){ ?>
<jdoc:include type="modules" name="project" style="yjsquare" /> 
<?php } ?>
</div>
</div>
<!-- end right block -->
<?php } ?>



</div><!-- end holder div -->
<!-- END BOTTOM PART OF THE SITE LAYOUT -->

</div><!-- end of insidewrap-->
</div> <!--end of wrap-->
</div><!-- end centerbottom-->


  <?php if ($this->countModules('user7') || $this->countModules('user8') || $this->countModules('user9') || $this->countModules('user10')) {?><!-- top bottoms -->

<div id="bottoms">
  <div id="bottoms_in"  style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">
  <?php if ($this->countModules('user7')) {?>
   <div id="user7" style="width:<?php echo $bottomwidth ?>;"><jdoc:include type="modules" name="user7" style="yjsquare" /></div><?php } ?>
    <?php if ($this->countModules('user8')) {?>
   <div id="user8" style="width:<?php echo $bottomwidth ?>;"><jdoc:include type="modules" name="user8" style="yjsquare" /></div><?php } ?>
     <?php if ($this->countModules('user9')) {?>
   <div id="user9" style="width:<?php echo $bottomwidth ?>;"><jdoc:include type="modules" name="user9" style="yjsquare" /></div><?php } ?>
       <?php if ($this->countModules('user10')) {?>
   <div id="user10" style="width:<?php echo $bottomwidth ?>;"><jdoc:include type="modules" name="user10" style="yjsquare" /></div><?php } ?>
  
  </div>
</div>

<!-- end bootoms --><?php } ?>

<!-- footer -->

<div id="footer">
<div id="youjoomla" style="font-size:<?php echo $css_font; ?>; width:<?php echo $css_width; ?>;">

<?php
# FOR YOUJOOMLA LLC COPYRIGHT REMOVAL VISIT THIS PAGE 
#http://www.youjoomla.com/faq/78.html
?>
<div id="cp">

<?php if($lang != "ru-RU"){ ?>
<?php echo getYJLINKS()  ?>
OCCRP is made possible by </div><div class="nesto"><span id="img_caption"></span><img class="donor" id="r1"></div>
<?php } else { ?>
<?php echo getYJLINKS_ru()  ?>
OCCRP существует благодаря </div><div class="nesto"><span id="img_caption"></span><img class="donor" id="r1"></div>
<?php } ?>
</div>
<div style="display: none;"><a href="https://plus.google.com/106731751199751777418" rel="publisher">Google+</a></div>

</div>

<!-- end footer -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-11396617-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script src="//platform.linkedin.com/in.js" type="text/javascript">
 lang: en_US
</script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
</body>
</html>

