<?php
/**
 * PHP Version 5.3+
 *
 * @category 
 * @package 
 * @author Ioana Cristea <ioana@serenitymedia.ro>
 * @copyright 2010 Serenity Media
 * @license http://www.gnu.org/licenses/agpl-3.0.txt AGPLv3
 * @link http://serenitymedia.ro
 */

class blog_requestHandler extends ivyModule
{
    var $handler;   // obj handlers like : archive, blog, home
    var $handlerPrefix = "blogHandler_";

    // from settings
    //var $methodHandles; //objHandlers; asa ar trebui redenumit
    var $tmplFiles;

    // determined;
    var $template_file;
    var $template_context;

    // these are blog variables
    /*var $tmpIdTree;
      var $tmpTree;
    */




    function get_handler($handlers , $handlerKey)
    {

        // determinam categoria care trebuie listata
        if (!isset($handlers[$handlerKey])) {
            error_log("[ ivy ] blog_handlers - _handle_requests :"
                     . " Atentie nu a fost setat nici un method handler pentru "
                     . " handlerKey = {$handlerKey}"
                     );
            return false;
        }

        /**
         * daca s-a cerut un record , reapeleaza functia recursiv
         * cu key handler pentru record
         */
        if (isset($_GET['idRec']) && $handlerKey!='idRec') {

            return $this->get_handler($handlers[$handlerKey], 'idRec');

        } else {

            error_log("[ ivy ] blog_handlers - _handle_requests :"
                . " A fost setat method handler = {".$handlers[$handlerKey]."} "
                . " pentru handlerKey = {$handlerKey}"
            );

            return $handlers[$handlerKey];
        }


    }
    function get_tmplFile($handler, $tmplKey = 'tmplFile')
    {
        /**
         * Daca avem request de un anumit recType , desi asta nu s-ar intampla
         * decat daca este cerut un record => in restul cazurilor este inutila
         */
        //echo "get_tmplFile";
        //var_dump($handler);
        if(isset($_GET['idRec']) && $tmplKey == 'tmplFile' ) {

            $recType = $this->template_context->format ?: $_GET['recType'];
            $tmplFile =  $this->get_tmplFile($handler, $tmplKey.'_'.$recType);
            if($tmplFile) {
                return $tmplFile;
            }
        }

        if (!isset($handler[$tmplKey])) {
            error_log("[ ivy ] blog_handlers - _handle_requests nu exista
            template file pentru  : $tmplKey " );
            return false;
        }
        return $handler[$tmplKey];
    }

    /**
     * determina un un obiect to handle the request
     * seteaza:
     *
     *  * $handler
     *  * $template_context
     *  * template_file
     * @uses
     */
    function _handle_requests()
    {
       // echo "blog_requestHandler";
        //var_dump($this->handlers);

        /**
         * Sufixul numelui handlerului
         */
        //echo "In the request Handler <br>";
        //var_dump($_REQUEST);
        $handlerId = $_REQUEST['hndl']
                     ? $_REQUEST['hndl']
                     : ( $this->idTree
                         ? $this->idTree
                         :($this->mgrName ? $this->mgrName : '')
                        );

        if(!$handlerId) {
            return false;
        }
        //$handler = $this->get_handler($this->handlers, $this->idTree);
        $handler = $this->get_handler($this->handlers, $handlerId);

        $objHandleName = $handler['handler'];

        //echo "object hander name = ".$this->handlerPrefix.$objHandleName;
        /**
         * handlerul este obiectul care se va ocupa de requesturi
         * ex: blog, archive, home , record = obiecte handler care se ocupa de
         * - datele necesare afisarii templateului
         * - de requesturile de delete, add, update ale adminului
         */
        $this->handler = $this->C->Module_Build_objProp(
                            $this, $this->handlerPrefix.$objHandleName);
        //echo "block here";

        if($this->handler) {
            /**
             * obiectul la care se va face referire din cadrul templateul
             * obiectul context ( feature nou - see CrenderTmpl)
             */
            $this->template_context = $this->handler;
            $this->template_file    = $this->get_tmplFile($handler);

            $this->C->jsTalk .="
             if( typeof ivyMods.blog == 'undefined'  ) {
                 ivyMods.blog = {};
             }
              ivyMods.blog.conf = {
                   templateFile: '".$this->template_file."'
              };
           ";
            //echo "template_file = ".$this->template_file;

            return true;
        } else {
            //echo "false handler";
            return false;
        }

    }

}