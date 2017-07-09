<?php
/**
 * Metode pe partea de admin
 *
 * Use to:
 * - Metode Locale proiectului
 * - metode care suprscriu metode din core
 * - metode experimentale
 *
 * daca se considera ca metodele vor fi general necesare
 * se trec in Cunstable => Ccore sau in clasa din care fac parte
 *
 */

class ACLcore extends ACcore
{
    /**
     * this validation is not a stable one
     *
     * aceasta metoda este foarte specifica
     * pentru referinta la ce anume foloseste see:
     * - handlePosts ( for : $mod->posts)
     * - Cfeedback
     * - AsampleMod.yml ( for: postExpected - the detailed model )
     *
     *
     * Used sofar by:
     * ACblogSite
     *  _hook_saveProfile()
     *
     *
     * @param $mod           - obiectul care a apelat metoda
     * @param $postExpected detailed ones with a fbk property
     * @param $validPosts
     *
     * @return bool
     */

    function emptyValidation($mod, $postExpected, $validPosts)
    {
        $validPostsArr = explode(',',$validPosts);
        $validation = true;
        foreach($validPostsArr AS $postName){

            $validation &= $mod->posts->$postName ? true :
                           $this->feedback->SetGet_badmessFBK(
                               $postExpected[$postName]['fbk']
                           );
        }
        return $validation;
    }

    //deci nu intra in functia asta. si habar nu am de ce.
    function _init_(& $dbLink){

        parent::_init_($dbLink);

        if($_SESSION['ivySett'] == 'frontAdmin') {
            $this->TOOLbar->ADDbuttons(
               "<span class='iedit-toolbarBtt'>
                    <form method='post' action=''>
                       <input type='hidden' name='ivySett' value=''>
                       <input type='hidden' name='tmplConst' value='true'>
                       <input type='submit' name='changeAdmin' value='backend admin'>
                    </form>
                </span>"
            );
        }
    }
}
