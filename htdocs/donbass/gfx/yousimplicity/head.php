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
defined( '_JEXEC' ) or die( 'Restricted index access' ); ?>
<?php if ($this->countModules('user1') || $this->countModules('user2') || $this->countModules('user3')) { ?>
<script type="text/javascript" src="<?php echo $yj_site ?>/src/slide.js"></script>
<?php } ?>
<?php if ($show_register == 1 || $top_panel == 1 || $this->countModules('inset')){ ?>
<script type="text/javascript" src="<?php echo $yj_site ?>/src/sve.js"></script>
<?php } ?>


<?php if ($this->countModules('inset')){ ?><!-- login -->
<script type="text/javascript">
window.addEvent('domready', function() {
$('showHideLogin').addEvent('click', function(){
if($('inset').status =='show'){
$('showHideLogin').innerHTML = 'Close'; // Login Close
<?php if ($show_register == 1){ ?>
$('showHideRegbox').innerHTML = 'Register';<?php } ?>
}else if ($('inset').status =='hide'){
$('showHideLogin').innerHTML = 'Login';
}
return true;
});
});
</script>
<?php } ?>
<?php if ($show_register == 1){ ?><!-- tools -->
<script type="text/javascript">
window.addEvent('domready', function() {
$('showHideRegbox').addEvent('click', function(){
if($('regbox').status =='show'){
<?php if ($this->countModules('inset')){ ?>
$('showHideLogin').innerHTML = 'Login';<?php } ?>
$('showHideRegbox').innerHTML = 'Close';// Register close
}else if ($('regbox').status =='hide'){
$('showHideRegbox').innerHTML = 'Register';
}
return true;
});
});
</script>
<?php } ?>
<script type="text/javascript">
window.addEvent('domready', function() {
new SmoothScroll({duration: 1000});	
});
</script>

<!--[if IE 6]>
<link href="<?php echo $yj_site ?>/css/ifie.php" rel="stylesheet" type="text/css" />
<style type="text/css">
#horiznav_d ul li ul{
width:<?php echo $css_width; ?>;
}
</style>
<![endif]-->

<!--[if IE]>
<style type="text/css">
body ol li,body ol li:hover{
margin-left:30px;
}
</style>
<![endif]-->
<?php if ( $menustyle == 1 || $menustyle == 2 || $menustyle == 5) {?>
<!--[if lte IE 7]>
		<script type="text/javascript">
		sfHover = function() {
			var sfEls = document.getElementById("horiznav").getElementsByTagName("LI");
			for (var i=0; i<sfEls.length; i++) {
				sfEls[i].onmouseover=function() {
					this.className+=" sfHover";
				}
				sfEls[i].onmouseout=function() {
					this.className=this.className.replace(new RegExp(" sfHover\\b"), "");
				}
			}
		}
		if (window.attachEvent) window.attachEvent("onload", sfHover);
		</script>
<![endif]-->
<?php }?>

<?php

echo '<script type="text/javascript" src="'.$yj_site.'/src/dw_event.js"></script>';
echo '<script type="text/javascript" src="'.$yj_site.'/src/dw_rotator.js"></script>';
echo '<script type="text/javascript" src="'.$yj_site.'/src/jquery-1.10.1.min.js"></script>';
?>
<script type="text/javascript">
  $.noConflict();
</script>


<script type="text/javascript">
var rotator1 = {
    path:   '/occrp/images/donors/',
    speed:  3000, // default is 4500
    id:   'r1',
    images: ["abc.gif", "bcd.jpg"], 
    bTrans: true, // ie win filter
    bMouse: true, // pause/resume
    captionId: 'img_caption',
    captions:   ["<a href='http://www.soros.org/initiatives/media'>Open Society Foundation media program</a>", "<a href='http://www.usaid.gov'>USAID</a>"]
}

var rotator2 = {
    path:   '/occrp/images/awards/',
    speed:  5000, // default is 4500
    id:   'r2',
    images: ["1.png", "2.png", "3.png", "4.png", "5.png"], 
    bTrans: true, // ie win filter
    bMouse: true, // pause/resume
    captionId: 'img_caption',
    captions:   ["", "", "", "", ""]
}

function initRotator() {
    dw_Rotator.setup(rotator1, rotator2);
}

dw_Event.add( window, 'load', initRotator);
</script>

<?php

if ( $menustyle == 2 ) {
echo '<script type="text/javascript" src="'.$yj_site.'/src/mouseover.js"></script>';
}?>
