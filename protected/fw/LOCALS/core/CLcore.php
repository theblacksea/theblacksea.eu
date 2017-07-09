<?php
/**
 * Use to:
 * - Metode Locale proiectului
 * - metode care suprscriu metode din core
 * - metode experimentale
 *
 * daca se considera ca metodele vor fi general necesare
 * se trec in Cunstable => Ccore sau in clasa din care fac parte
 *
 */
class CLcore extends Ccore
{

    public function Set_lastURL() {
        $_SESSION['lastURL'] = $_SESSION['lastURL'] == '/' ?: Toolbox::curURL();
    }

    function _init_(&$dbLink){
        parent::_init_($dbLink);
        require_once PUBLIC_PATH.'assets/Mobile-Detect/Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $mobile =  $detect->isMobile() && !$detect->isTablet();

        if($mobile){
            $_SESSION['ivySett'] = 'mobile';
        }
    }

}
