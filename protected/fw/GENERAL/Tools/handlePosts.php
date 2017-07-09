<?php

/**
 * BASED ON:
 * - expectedPosts is an array that can take many forms
 * - elemente trebuie sa fie declarate totusi in acelasi fel
 * - iata cateva exemple de combinatii
 *
 *--------------------------------------------------------------------------
 * ## Exemplu 1
 *--------------------------------------------------------------------------
 *
 * ** array-ul furnizat **
 * expectedPosts :
 *   propName1 :
 *       postName: 'someValue'
 *       [fbk_something: {type: 'error, warning, mess'}]
 *       [validate : [noEmpty, etc..]]
 *  propName2 :
 *      postName: ''
 *
 *  propName3: []
 *
 *
 * ** Nota **
 * - numele proprietatilor (propName) vor avea mereu ca valoare un array
 * chiar daca acesta este gol
 *
 * ** Returned result **
 *
 * => posts (object)
 *      ->propName1 = $_POST[array['postName']]
 *      ->propName2 = $_POST[propName2]
 *      ->propName3 = $_POST[propName3]
 *
 *--------------------------------------------------------------------------
 * ## Exemplu2
 *--------------------------------------------------------------------------
 *
 * ** array-ul furnizat **
 *
 * expectedPosts :
 *   propName1: 'postName1'
 *   propName2: ''
 *
 * ** Nota **
 * - propName vor avea mereu ca valoare un string , reprezentand posibilul
 * nume al postului
 *
 * ** Returned result **
 *
 * => posts (object)
 *      ->propName1 = $_POST[postName1]
 *      ->propName2 = $_POST[propName2]
 *
 *--------------------------------------------------------------------------
 * ## Exemplu3
 *--------------------------------------------------------------------------
 *
 * ** array-ul furnizat **
 *
 * expectedPosts: [ propName1, propName2, ...]
 *
 * ** Nota **
 *
 * - postName vor fi = propName
 *
 * ** Returned result **
 *
 * => posts (object)
 *      ->propName1 = $_POST[propName1]
 *      ->propName2 = $_POST[propName2]
 *
 *
 */
class handlePosts
{
    //sanitzation methods
    static function realEscapeString(&$post){
        global $dbLink;
        $post = $dbLink->real_escape_string($post);
    }
    static function stripTags(&$post){
        $post = strip_tags($post);
    }

    /**
     * @param $sanitizations : ["stripTags", "realEscapeString"] (from etc)
     * @param $post - postValue
     *
     * @uses
     */
    static function sanitize_post($sanitizations, &$post){
        foreach($sanitizations AS $sanitization){
            if(method_exists(handlePosts, $sanitization)){
                handlePosts::$sanitization($post);
            }
            //echo " | {$sanitization}";
        }
    }

    //validation controler
    /**
     * daca exista metoda de validare definita in Toolbox
     * daca validarea este falsa seteaza un mesaj de feedback cu informatiile
     * definite in etc-ul modulului
     *
     * bio:
     *  validation:
           0: {check: "notEmpty", type: "warning", name: "Biography", mess: "You should write something about you"}
     *
     * @param        $post - valoarea postului
     * @param        $validation - informatiile pentru validare ( functia & datele mesajului de eroare)
     * @param string $fbk - obiectul care seteaza feedbackul
     *
     * @uses
     * @return bool
     */
    static function validate_post($post, $validation, &$fbk = ''){
        $checkFunc = $validation['check'];
        $postValidation = true;
        if(method_exists(Validation, $checkFunc) ){
            $postValidation = Validation::$checkFunc($post) == 1
                           ? true
                           : ( !$fbk ? false : $fbk->SetGet_badmessFbk($validation) );

        }
        return $postValidation;
    }
    /**
     * example from settings - etc:
    sanitize_default: &id001
      - "stripTags"
      - "realEscapeString"

    post_addUser:
      bio:
        validation:
          0: {check: "notEmpty", type: "warning", name: "Biography", mess: "You should write something about you"}
      photo: []
      first_name:
        sanitize: *id001
        validation:
          0: {check: "notEmpty", type: "error", name: "Empty First Name", mess: "Please enter your name"}
          1: {check: "alpha", type: "error", name: "First Name", mess: "Containes unallowed characters"}
      last_name:
    */
    static function process_postsFlexy( &$posts, $expectedPost, &$fbk=''){
        //var_dump($expectedPost);
        $validation = true;
        foreach($expectedPost AS $postName => $postDetails){
            //echo "<b>$postName</b> <br>";

            //sanitize strings
            $pd = $postDetails;
            if(isset($pd['sanitize']) && is_array($pd['sanitize'])){
                handlePosts::sanitize_post($pd['sanitize'], $posts->$postName);
            }
            // validate post
            if(isset($pd['validation']) && is_array($pd['validation'])){
                foreach($pd['validation'] AS $validation){
                    $postValidation = handlePosts::validate_post($posts->$postName,$validation, $fbk);
                    $validation &= $postValidation;

                    /*
                     *  daca s-a gasit o validare falsa pe un camp se opreste pe respectiva validare
                    */
                    if(!$postValidation) {
                        break;
                    }
                }
            }
        }
        return $validation;
    }

    /**
     * Returneaza un obiect cu toate posturile asociate ca proprietati
     * @return posts
     */
    static function Get_post()
    {
        $posts = new stdClass();
        foreach($_POST AS $key => $val){
            $posts->$key = trim($val);
        }

        return $posts;

    }

    /**
     * @param $propName = key-ul array-ului
     * @param $postName = value array
     */
    function Set_postStrict(&$propName, &$postName)
    {
        $propName =  $postName;
       // echo"postName = $postName ===  propName = $propName<br>";
    }
    function Set_postSelectiv(&$propName, &$postName)
    {
        $postName =  $postName ? $postName : $propName;
    }
    function Set_postDescription(&$propName, &$postName)
    {

        $postName =  isset($postName['postName']) && $postName['postName']
                     ? $postName['postName']
                     : $propName;

    }

    /**
     * ## Returneaza numele metodei de determinare a propName & postName
     *--------------------------------------------------------------------------
     *
     * ** determinarea tipului de exepectedPosts **
     *
     * propName poate sa fie
     *  - number
     *      => este un vector numeric
     *      => metoda = Strict
     *  - string
     *      => este un vector asociativ
     *         - daca $postName == array
     *              => postName = array('postName' => 'valuePostName')
     *              => metodata = Description
     *          - daca $postName == string
     *              => postName = numele postului
     *              => metodata = Selective

     *
     * @param $expectedPosts
     *
     * @return string - numele metodei de determinare a propName & postName
     */
    static function Get_postMethod($expectedPosts)
    {

        reset($expectedPosts);
        $firstPropName = key($expectedPosts);
        $firstPostName = current($expectedPosts);

        // method like = Get_postNameStrict / Get_postNameSelectiv / Get_postNameDesction
        $postMethod ='Set_post'.(is_numeric($firstPropName)
                                    ? "Strict"
                                    :( is_array($firstPostName)
                                        ? "Description"
                                        : "Selectiv")
                                );
        /**
         * echo "handlePosts - Get_postmethod :
              <b>firstPropName = $firstPropName
               ".(is_numeric($firstPropName) ? "<b>numeric</b>" : "not numeric")."
              firstPostName = $firstPostName</b>
              <br>
        ";*/
        // echo "<b>postMethod {$postMethod} </b><br>";
        return $postMethod;
    }
    /**
     * ## Stepts - Get_postsFlexy
     *--------------------------------------------------------------------------
     * #1
     * + daca nu expectedPOsts nu este un string atunci
     *      + seteaza numele metodei de determinare a propName & postName
     *      + altfel inseamna ca numele posturilor au fost delimitate de ", "
     *         metoda este "Strict" & expectedPost este facut array
     *
     * #2
     * + Apelare metoda asociata tipului de array pentru fiecare element in parte
     * + daca avem concat => vom concatena postName si testa daca exista asa
     *                  , daca nu testam direct cu postName
     *
     * + retinem postValue
     * + daca postValue nu este empty  sau putem sa adaugam si empty (!$notEmpty )
     *   o adaugam in obiectul de posts
     * + la starsit returnam obiectul de posts
     *
     *
     * @param        $expectedPosts
     * @param string $concat
     * @param bool   $notEmpty
     *
     * @return stdClass
     */
    static function Get_postsFlexy($expectedPosts, $concat='', $notEmpty = false)
    {
        //#1
        if(!is_string($expectedPosts)) {
            $postMethod = handlePosts::Get_postMethod($expectedPosts);
        } else {
            $postMethod    = "Strict";
            $expectedPosts = explode(', ', $expectedPosts);
        }
        /**
         * echo "handlePosts - Get_postsFlexy: expectedPost <br>";
        var_dump($expectedPosts);
        echo "handlePosts - Get_postsFlexy: postMethod = $postMethod <br>";
        echo "//////////////////////////////////////////////////////////////////////// <br>";*/

        //#2
        $concat     = $concat ? "_".$concat : '';
        $posts      = new stdClass();

        foreach( $expectedPosts  AS $propName => $postName ) {

           handlePosts::$postMethod($propName, $postName);
           $postValue = isset($_POST[$postName.$concat])
                               ? $_POST[$postName.$concat]
                               : (isset($_POST[$postName])
                                  ? $_POST[$postName]
                                  : ''
                                 );

            $postValue = trim($postValue);
            if($postValue || !$notEmpty) {
                $posts->$propName = $postValue;
            }
        }

        return $posts;
    }

    // db helpers
    static function Db_Get_setString($objPosts, $strPosts, $notEmpty = true)
    {
        $sets = array();
        $arrPosts = explode(',', $strPosts);

        foreach($arrPosts AS $postName) {
            $postName  = trim($postName);
            $postValue = isset($objPosts->$postName) ? $objPosts->$postName : '';
            // daca exista valoarea sau nu este nevoie sa existe
            if((isset($objPosts->$postName) && $postValue)
                || !$notEmpty
            ) {
                array_push($sets, "$postName = '{$postValue}'");
            }
        }

        $set = implode(', ', $sets);
       // echo "Db_Get_setString = $set <br>";

        return $set;

    }

}
