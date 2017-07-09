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

class blog_rowDb
{
    var $blog; // pointer la obiectul principal blog

    function GET_solve_quotes($string){
        if(!$string) return;
        return str_replace(array( "''", '&#39;&#39;', '&#039;&#039;'),
                           array("'", '&#39;', '&#039;'),
                           $string);

    }
    function SET_Solve_quotes($string, $fieldName = ''){
        if(!$string) return;
        $solvedString = str_replace(array("'", '&#39;', '&#039;'),
                                       array( "''", '&#39;&#39;', '&#039;&#039;'),
                                        $string);
       /* error_log( "fieldName = {$fieldName} \n ".
             "{$solvedString}");*/
        return $solvedString;
    }
    function Get_content($content, $lenght = '' )     {

        // nu are logica aceasta conditie
        if(!$content) {
            return;
        }
        $content = str_replace(array("'", "&#39;"),
                               array( "''", "&#39;&#39;"),
                               $content);
        if($lenght){
             $string =    substr(strip_tags($content),0,$lenght);
             return substr($string, 0, strrpos( $string, ' ') );
        }
        return $content;
    }
    function Get_content_noPic(&$row, $lenght = 100){

        if (preg_match_all("/<img\b[^>]+?src\s*=\s*[\'\"]?([^\s\'\"?\#>]+).*\/>/", $row['content'], $matches))
        foreach($matches[0] AS $match)
            $row['content'] = str_replace($match,'',$row['content']);

        #var_dump($matches[0]);

         if($row['content']){
             $string =    substr(strip_tags($row['content']),0,$lenght);
             return substr($string, 0, strrpos( $string, ' ') );
         }
         else
             return $row['content'];
    }
    function Get_leadSec(&$row, $lenght = 70)       {

         if(!$row['leadSec']){

             $string = $row['lead']
                       ? substr(strip_tags($row['lead']),0,$lenght)
                       : substr(strip_tags($row['content']),0,$lenght);
             return substr($string, 0, strrpos( $string, ' ') );
         } else {
             return $row['leadSec'];
         }
    }
    function Get_recordPics(&$row)                  {
        preg_match_all('/(?<=\<img).+src=[\'"]([^\'"]+)/i', $row['content'], $matches);
        return $matches;
    }

    function Get_contentWithoutImages(&$row){
        return preg_replace("/<img[^>]+\>/i", "(image) ", $row['content']);
    }

    function Get_record_mainPic(&$row)              {
         #====================================[ main Pic ]===========================================================================

        $matches = $this->Get_recordPics($row);
        if ($matches[1]) {
            $urlPath  = $matches[1][0];
            $path     = pathinfo($urlPath);
            $urlParts = parse_url($urlPath);
            $urlHost  = 'http://'.$urlParts['host'].'/';

            $base = str_replace('uploads/', 'uploads/.thumbs/', $path['dirname'])
                    . '/'
                    . $path['filename'];

            $base_path = str_replace($urlHost, PUBLIC_PATH, $base);
            $base      = str_replace($urlHost, BASE_URL, $base);
            $ext       = $path['extension'];

            $thumbnail1 = $base . '-small.' . $ext;
            $thumbnail2 = $base . '_300250.' . $ext;

            // paths
            $thumbnail1_path = urldecode($base_path . '-small.' . $ext);
            $thumbnail2_path = urldecode($base_path . '_300x250.' . $ext);

            $default = '/RES/uploads/images/wp/2010/05/1.jpg';

            //nu merge asa si nu inteleg de ce
            $thumbnail = file_exists($thumbnail1_path)
                        ? $thumbnail1
                        : (file_exists($thumbnail2_path)
                           ? $thumbnail2
                           : ''
                        );

            /*if(!$thumbnail) {
                echo "path = $path <br>
                     urlHost =  $urlHost <br>
                     thumbnail= $thumbnail1_path ". (file_exists($thumbnail1_path) ? '-file exist' : 'NO FILE')."<br>".
                     "thumbnai2= $thumbnail2_path ". (file_exists($thumbnail2_path) ? '-file exist' : 'NO FILE'). "<br>"
                      ."<img src = '$thumbnail2'>"
                      ."<br>_____________________________________<br>";
            }*/
            $thumbnail = $thumbnail ?: $default;

            return  $thumbnail;
        }
        # echo $row['title']."<br>".var_dump($matches)."<br>";
    }

    function Get_record_href(&$row)                 {

       return "index.php?idT={$row['idTree']}".
                 "&idC={$row['idCat']}".
                 "&idRec={$row['idRecord']}".
                 //"&type={$currentLayout}".
                  ($row['format'] && $row['format']!='blog' ? "&recType={$row['format']}" : '');

    }
    function Get_record_authorHref($uid)            {

        return "index.php?idT=3".
                         "&idC=3".
                         "&uid={$uid}";

    }
    function Get_record_hrefFolderFilter($idFolder) {

        // using a method from anothe blog object = filters

        $href = "?idT={$this->idTree}&idC={$this->idNode}&"
                .$this->blog->filters->hrefFilter('idFolder', $idFolder);
        return  $href;

    }
    function Get_tagsArray($tagsName)               {
        $tags = str_getcsv($tagsName, ',');
        foreach($tags AS $key=>$tag) {
            $tags[$key] = trim($tag);
        }

        return $tags;
    }
    function Get_publishedStatus ($publishDate)     {
        return $publishDate ? 'record-published' : 'record-unpublished';

    }
    function Get_recordHrefHome($row)               {
        // cine este tmpIdTree??
        return  "index.php?idT={$this->blog->tmpIdTree}".
                  "&idC={$row['idCat']}".
                  "&idRec={$row['idRecord']}".
                   ($row['format'] && $row['format']!='blog' ? "&recType={$row['format']}" : '');
    }
    function Get_authors($uids, $fullNames)         {
        $authors    = array();
        foreach ($uids AS $key => $uid) {
            array_push($authors, array(
                    "uid" => $uid,
                    "fullName" => $fullNames[$key],
                    "authorHref" => $this->Get_record_authorHref($uid)
                ));
        }
        //var_dump( $authors);

        return $authors;
    }

    function Get_rights_articleEdit($uidRec, $uids = array())
    {
        $editRight = $this->C->user->uid
                     && ($this->C->user->rights['article_edit']
                         ||  $uidRec == $this->C->user->uid
                         || in_array($this->C->user->uid, $uids)
                     ) ;
        /*echo "Userul articles_edit = ".$this->C->user->rights['article_edit']
              . " autor({$uidRec}) = ". $this->C->user->uid. " " .($uidRec == $this->C->user->uid ? 'DA' : "NU");*/
        //var_dump($this->C->user->rights);
        return $editRight;
    }
    /**
     * Daca este un user logat
     *      - daca are permisiuni de master poate edita
     *      - daca nu are permisiuni
     *              - si este autorul recordului  - poate edita
     *
     */
    function Get_recordED($uidRec, $uids = array())
    {
        $editRight = $this->Get_rights_articleEdit($uidRec, $uids);
        //var_dump($this->user->rights);
        // error_log("[ ivy ] ACblog - Get_recordED pt {$uidRec} permisiuni = {$editRight} ");

        return !$editRight ? 'not' :'';
    }

    function Get_highlightWords($string, $words){
        $string = strip_tags($string);

        foreach($words AS $word) {
            $replaceString = "<b>{$word}</b>";
            $string =  str_replace($word, $replaceString, $string);
        }
        return $string;
    }
    function Get_highlightWordsParts($string, $words, $type){
        $string = strip_tags($string);
        $parts = array();
        $positionStarPrev =  $positionStart = 0;
        $positionEndPrev = $positionEnd = $stringSize = strlen($string);

       // echo "<b>for text = </b> $string <br> ";
        foreach($words AS $word) {
            //echo "<br><b>for word = </b> {$word} <br>";
            $position = strpos($string, $word);
            if(!$position) {
                //echo "the word was not found <br>";
            } else {
                $wordSize = strlen($word);

                // position Star;
                $positionStartTmp = $position - 100;
                if($positionStartTmp > $positionStart){ $positionStart = $positionStartTmp; }

                //position End
                $positionEndTmpl = $position + $wordSize + 100;
                if($positionEndTmpl < $positionEnd) {
                    $positionEnd = $positionEndTmpl;
                    $lengthSubstr = $wordSize + 200;
                }


                //
                $string = substr($string, $positionStart, $lengthSubstr);
                $parts[$positionEnd] =  substr($string, 0, strrpos( $string, ' ') );
                /*echo "type = $type & positionStar = $positionStart &
                positionEnd = $positionEnd <br> text = ". $parts[$positionEnd]. "<br>"
                ." first space ".strrpos( $string, ' ')."<br>";*/

                //
                $positionStarPrev = $positionStart;
                $positionEndPrev = $positionEnd;

                $replaceString = "<b>{$word}</b>";
                $parts[$positionEnd] =  str_replace($word, $replaceString, $parts[$positionEnd] );
                if($positionStart != 0) {
                    $parts[$positionEnd] = '...'.$parts[$positionEnd];
                }
            }
        }

        if(count($parts)) {
            $string = implode('', $parts);
            if($positionEnd < $stringSize) {
                $string = $string.'...';
            }
        } else {
            return '';
            /*if($stringSize > 100) {
                $string = substr($string, 0, 200);
                $string = substr($string, 0, strrpos( $string, ' ') );
            }*/
        }

        //echo "-----------------------------------------------------------------------<br>";
        return $string;
    }
}
