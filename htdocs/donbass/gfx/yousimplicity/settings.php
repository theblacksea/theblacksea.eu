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
defined( '_JEXEC' ) or die( 'Restricted index access' );
$yj_site = JURI::base()."templates/".$this->template;
$yj_base = JURI::base();

require( TEMPLATEPATH.DS."links.php");


$default_color = $this->params->get("defaultcolor", "dark"); // set the default lime | cyan | purple 
$default_font  = $this->params->get("fontsize", "medium"); // SMALL | MEDIUM | BIG
$default_width = $this->params->get("sitewidth", "wide"); // WIDE | NARROW  


//TOOLS CONTROL
$showfont = $this->params->get("showfont", "1"); // SHOW FONT SWITCH = 1 | HIDE FONT SWITCH = 0
$showcolor = $this->params->get("showcolor", "1");// SHOW COLOR SWITCH = 1 | HIDE COLOR SWITCH = 0
$showwidth = $this->params->get("showwidth", "0"); // SHOW WIDTH SWITCH = 1 | HIDE WIDTH SWITCH = 0

// SUCKERFISH  MENU SWITCH // 
$menu_name = $this->params->get("menuName", "mainmenu");// mainmenu by default, can be any Joomla! menu name

//MENU STYLE SWITCH//
$menustyle = $this->params->get("menustyle", "2");  //  1 = Standard Dropdown (Suckerfish)  | 2  = SMooth Dropdown | 3  = Split Menu

// SLIDE SHELF OPTIONS//  

$slide_type                     = $this->params->get ("slide_type", "scroll");  // fade | scroll | scrollfade
$slide_pageload                 = $this->params->get ("slide_pageload", "forward");  //  forward | stop   |  Start slide on page load  | forward = yes  |  stop = no
$slide_time                     = $this->params->get ("slide_time", "3000");     //   pause between slides  1000 = 1sec
$slide_duration                 = $this->params->get ("slide_duration", "500");     //    slide transition speed

$top_panel                = $this->params->get ("top_panel", 1);     // 
$about_link               = $this->params->get ("about_link", 1); 
$show_about_link               = $this->params->get ("show_about_link", 1); 
$show_register               = $this->params->get ("show_register", 1); 
 
// USE SERVER SIDE SCRIPT AND CSS COMPRESSION FOR FASTER PAGE LOAD 
// mod_gzip module  MUST BE ENABELED IN PHP.INI
// IF YOU ARE NOT SUER WHAT THIS IS LEAVE THIS SETTING 0
$compress = $this->params->get("compress", "0");	 // 1 = TURN COMPRESSION ON  |  0 = TURN COMPRESSION OFF 
// SEO SECTION //
$seo                    = $this->params->get ("seo", "Joomla 1.5 Template By Youjoomla.com");                      # JUST FOLOW THE TEXT
$tags                   = $this->params->get ("tags", "Joomla Templates by Youjoomla, Joomla Template Club, Youjoomla");# JUST FOLOW THE TEXT
$ie6notice  = $this->params->get("ie6notice", "0"); // 1 = ON | 0 = OFF   
// ADVISE VISITORS THAT THIR JAVASCRIPT IS DISABLED
$nonscript  = $this->params->get("nonscript", "0"); // 1 = ON | 0 = OFF 
#DO NOT EDIT BELOW THIS LINE//////////////////////////////////////////////////////////////////////////
$show_register = $this->params->get("show_register", "1");

require( TEMPLATEPATH.DS."styleswitcher.php");

if ($top_panel == 1){
$body_color = 'colortp';
}else{
$body_color = 'color';
}

//START COLLAPSING THAT MODULE:)
$left = $this->countModules( 'left' );
$right = $this->countModules( 'right' );
if ( $left  &&  $right  ) {
	
	$leftblock  = '22.5%';
	$midblock = '55%';
	$rightblock  = '22.5%';
	$wrap    = 'wrap';
    $insidewrap='insidewrap';
	
	}elseif ( $left) {
	$midblock = '72%';
	$leftblock  = '28%';
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	
	}elseif ( $right) {
	$midblock = '72%';
	$rightblock  = '28%';
	$wrap    = 'wrap';
	$insidewrap='insidewrapblank';

	} else {
    $midblock = '100%';
	$wrap    = 'wrapblank';
	$insidewrap='insidewrapblank';
	}

$tops = 0;
if ($this->countModules('user4')) $tops++;
if ($this->countModules('user5')) $tops++;
if ($this->countModules('user6')) $tops++;
if ( $tops == 3 ) {
	$topswidth = '33.3%';}
elseif ( $tops == 2 ) {
	$topswidth = '50%';
} else if ($tops == 1) {
	$topswidth = '100%';
}



$users_show = 0;
if ($this->countModules('user1')) $users_show++;
if ($this->countModules('user2')) $users_show++;
if ($this->countModules('user3')) $users_show++;
if ( $_SESSION['width'] == "wide" && $users_show){
$SlideBox_f ="2820px"; // full all slides togheter
$SlideBox_m ="940px"; //module
$slidebox_width = "940px"; // site width minus padding (#slideshow) for navigation
}
elseif( $_SESSION['width'] == "narrow" && $users_show){
$SlideBox_f ="2148px"; // full all slides togheter
$SlideBox_m ="716px"; //module
$slidebox_width = "716px"; // site width minus padding (#slideshow) for navigation
}
//START COLLAPSING TOP:)
$bottom = 0;
if ($this->countModules('user7')) $bottom++;
if ($this->countModules('user8')) $bottom++;
if ($this->countModules('user9')) $bottom++;
if ($this->countModules('user10')) $bottom++;
if ( $bottom == 4 ) {
	$bottomwidth = '25%';}
elseif ( $bottom == 3 ) {
	$bottomwidth = '33.3%';}
elseif ( $bottom == 2 ) {
	$bottomwidth = '50%';
} else if ($bottom == 1) {
	$bottomwidth = '100%';
}

// -- figure out what URL to use for prefix
// -- Loop through existing prefix to get all of the variables
$my_vars = $_GET;
$my_url = "";
if(!empty($my_vars)) {
// -- Get HTTP String 1179 and Loop through the vars that are passed and make sure they are not any of the reserved ones
foreach($my_vars as $col => $val) {
if($col != "change_font" && $col != "change_width" && $col != "change_css") {
$my_url .= $col ."=".$val . "&amp;";
}
}
$my_request = $_SERVER["PHP_SELF"]."?".substr($my_url, 0, -5)."&amp;"; // -- Add some more
}else{
$my_request = $_SERVER["PHP_SELF"]."?"; // -- All alone
}
function getCurrentURL(){
$cururl = JRequest::getURI();
if(($pos = strpos($cururl, "index.php"))!== false){
$cururl = substr($cururl,$pos);
}
$cururl = JRoute::_($cururl);
$cururl = ampReplace($cururl);
return $cururl;
}

if ($compress == 1){
$jsextens ='php';
$cssextens ='php';
}else{
$jsextens ='js';
$cssextens ='css';
}




// menu code
	$document	= &JFactory::getDocument();
	$renderer	= $document->loadRenderer( 'module' );
	$options	 = array( 'style' => "raw" );
	$module	 = JModuleHelper::getModule( 'mod_mainmenu' );
	$topmenu = false; $subnav = false; $sidenav = false;
	

	// SPLIT MENU  NO SUBS

		
// SUCKERFISH OR MOO
	if ($menustyle == 1 or $menustyle== 2) :
		$module->params	= "menutype=$menu_name\nshowAllChildren=1\nclass_sfx=nav";
		$topmenu = $renderer->render( $module, $options );
		$menuclass = 'horiznav';
		$topmenuclass ='top_menu';
	
		elseif ($menustyle == 5) :
		$module->params	= "menutype=$menu_name\nstartLevel=0\nendLevel=1\nclass_sfx=split";
		$topmenu = $renderer->render( $module, $options );
		$menuclass = 'horiznav';
		$topmenuclass ='top_menu';
		
	endif;

?>