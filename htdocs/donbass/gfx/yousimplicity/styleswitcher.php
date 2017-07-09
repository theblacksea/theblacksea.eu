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
if(!isset($_SESSION))
{
session_start();
} 

$mystyles = array();


$mystyles['pink']['file'] = "pink";
$mystyles['dark']['file'] = "dark";
$mystyles['green']['file'] = "green"; 


$mystyles['pink']['label'] = '<span title="Change site color to Pink">Pink</span>&nbsp;&nbsp;';
$mystyles['dark']['label'] = '<span title="Change site color to Dark">Dark</span>&nbsp;&nbsp;';
$mystyles['green']['label'] = '<span title="Change site color to Green">Green</span>&nbsp;&nbsp;';


if (isset($_GET['change_css']) && $_GET['change_css'] != "") {
    $_SESSION['css'] = $_GET['change_css'];
} else {
    $_SESSION['css'] = (!isset($_SESSION['css'])) ? $default_color : $_SESSION['css'];
}
switch ($_SESSION['css']) {
    case "pink":
    $css_file = "pink";
    break;
    case "dark":
    $css_file = "dark";
    break;
	case "green":
    $css_file = "green";
    break;
	default:
    $css_file = "dark";

}




//FONT SWITCH

$myfont = array();


$myfont['small']['file'] = "9px";
$myfont['medium']['file'] = "12px";
$myfont['large']['file'] = "16px"; // default

$myfont['large']['label'] = '<span class="fl" title="Change fonts size to Large">F</span>';
$myfont['medium']['label'] = '<span class="fm" title="Change fonts size to Medium">F</span>';
$myfont['small']['label'] = '<span class="fs" title="Change fonts size to Small">F</span>';





if (isset($_GET['change_font']) && $_GET['change_font'] != "") {
    $_SESSION['font'] = $_GET['change_font'];
} else {
    $_SESSION['font'] = (!isset($_SESSION['font'])) ? $default_font : $_SESSION['font'];
}
switch ($_SESSION['font']) {
    case "small":
    $css_font = "9px";
    break;
    case "medium":
    $css_font = "12px";
    break;
	case "large":
    $css_font = "16px";
    break;
    default:
    $css_font = "12px";
}

//WIDTH SWITCH


$mywidth = array();

$mywidth['narrow']['file'] = "776px";
$mywidth['wide']['file'] = "1000px";

$mywidth['narrow']['label'] = '<span title="Change site width to Narrow">Narrow</span>&nbsp;';
$mywidth['wide']['label'] = '<span title="Change site width to Wide">Wide</span>&nbsp;';


if (isset($_GET['change_width']) && $_GET['change_width'] != "") {
    $_SESSION['width'] = $_GET['change_width'];
} else {
    $_SESSION['width'] = (!isset($_SESSION['width'])) ? $default_width : $_SESSION['width'];
}
switch ($_SESSION['width']) {
    case "wide":
    $css_width = "1000px";
	$bannerwidth="468px";
    break;
    case "narrow":
    $css_width = "776px";
	$bannerwidth="440px";
    break;
	default:
    $css_width = "1000px";
	$bannerwidth="468px";

}
?>