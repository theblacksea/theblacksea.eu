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

class AblogHandler_record extends blogHandler_record
{
    var $authors;
    var $fbk;
    var $user;
    var $posts;


    function Get_blogCategories(){
        //@todo: aceast mod de aface lucrurile  este temporar
        $cats = $this->tree[$this->idTree]->children;

        if(!$cats) {
            return false;
        }
        $catsStr = implode(', ', $cats);

        $query = "SELECT id AS idCat , name_en AS catName
                    FROM ITEMS
                    WHERE type='blog' AND id IN ($catsStr) ";
        $blogCategories = $this->C->Db_Get_rows($query);

        return $blogCategories;
    }

    function _hookRow_record($row)
    {
        if(!$row['commentsView'])   {$row['commView_true'] = '';   $row['commView_false'] = 'checked'; }
        if(!$row['commentsStat'])   {$row['commStat_true'] = '';   $row['commStat_false'] = 'checked'; }
        if(!$row['commentsApprov']) {$row['commApprov_true'] = ''; $row['commApprov_false'] = 'checked'; }

        $row = parent::_hookRow_record($row);
        // nu prea isi are rostul daca nu poate administra
        $row['blogCategories'] = $this->Get_blogCategories();
        $row['record_mainPic']   = $this->rowDb->Get_record_mainPic($row);

        $this->ED = !$row['authorRights'] ? 'not' :'';


        return $row;
    }
    function record_setAuthors()
    {
        // relate to $this->Get_authors;
        $selectedAuthors = array();
        if(is_array($this->authors)){
            foreach ($this->authors AS $key => $author) {
                array_push($selectedAuthors, array(
                        'id' => $author['uid'],
                        'name' => $author['fullName']
                    ));
            }
            $authorsJSON = json_encode($selectedAuthors);
            $this->C->jsTalk .= "
            if( typeof ivyMods.blog == 'undefined'  ) {
                ivyMods.blog = {};
            }
            ivyMods.blog.authors = $authorsJSON;
        ";
        }

        //echo "<b>ACblog - record_setAuthors</b><br>";
       /* var_dump($selectedAuthors);
        var_dump(json_encode($selectedAuthors));*/



    }

    function record_setData()
    {

        //$this->C->Module_Set_incFiles($this, 'js','js_record');
        // preluarea datelor de record
        parent::record_setData();
        $this->record_setAuthors();

    }

    // db methods
    // update record methods
    function Get_validTags($tagsStr)
    {
        /**
         *  - trim
         *  - mai mult de 2 caractere
         *  - not in banned tags
         *  - not including banned characters like *,&,^ etc
         *
         *  - tagurile valide vor fii adaugate in valid_tags
         *    iar cele invalide se vor adauga la stringul faildTags
         *
         * - LANGUAGE SUPPORT???
         */

        $tags = explode(",", $tagsStr);
        $banned_tags = array();

        $res = $this->DB->query("SELECT tagName FROM blogTags_banned");
        while ($row = $res->fetch_assoc()) {
            array_push($banned_tags, $row['tagName']);
        }

        #=======================================================================
        $faild_tags_arr = array();
        $valid_tags     = array();
        $unique_tags    = array_unique($tags);

        foreach ($unique_tags AS $tag) {
            $tag = strtolower(trim($tag));
            if (/*Validation::alphanum($tag,2)  && */!in_array($tag, $banned_tags)) {
                if($tag){
                    array_push($valid_tags, $tag);
                }
            } else {
                    array_push($faild_tags_arr, $tag);
            }
        }
        #======================================[ set warning message ]==========
        $faildTagsStr = implode(', ',$faild_tags_arr);
        if ($faildTagsStr) {
            $postsConf = &$this->posts_updateRecord;
            $postsConf['recordTags']['fbk']['mess'] .= $faildTagsStr;
            $this->fbk->Set_messFbk($postsConf['recordTags']['fbk']);
        }

        return $valid_tags;



    }

    function createAltFromExif($document)
    {
        $dom = new DomDocument;
        //$dom->loadHTML($document,LIBXML_HTML_NODEFDTD);
        //$dom->loadHTML(mb_convert_encoding($document, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $dom->loadHTML(mb_convert_encoding($document, 'HTML-ENTITIES', 'UTF-8'),  LIBXML_HTML_NODEFDTD);
        $dom->encoding = 'UTF-8';
        $dom->normalizeDocument();
        foreach ($dom->getElementsByTagName('img') as $item) {
            $alt = $item->getAttribute('alt');

            if (strlen($alt) < 1) {
                $src  = str_replace(
                    'uploads/images/',
                    'uploads/.thumbs/images/',
                    $item->getAttribute('src')
                );

                $curlSession = curl_init();
                curl_setopt($curlSession, CURLOPT_URL, $src . '.exif');
                curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

                $exif = json_decode(curl_exec($curlSession));
                curl_close($curlSession);

                if (strlen(trim($exif->ImageDescription)) > 0) {
                    //var_dump($exif->ImageDescription);
                    $item->setAttribute('alt', $exif->ImageDescription);
                    $exif->ImageDescription;
                }
            }
        }

        return $dom->saveHTML();
    }

    function updateRecord_processData(&$posts)
    {
        // encript
        $this->posts->title         =  htmlentities($this->posts->title, ENT_QUOTES);
        $this->posts->leadSec       =  htmlentities($this->posts->leadSec, ENT_QUOTES);
        $this->posts->country       =  htmlentities($this->posts->country, ENT_QUOTES);
        $this->posts->city          =  htmlentities($this->posts->city, ENT_QUOTES);
        $this->posts->relatedStory  =  htmlentities($this->posts->relatedStory, ENT_QUOTES);
        $this->posts->skipIndex     =  $this->posts->skipIndex ? 1 : null;
        $this->posts->content       =  $this->createAltFromExif($this->posts->content);

        foreach($this->quotesProblemsFields AS $field){
            if($this->posts->$field) {
                $this->posts->$field = $this->rowDb->SET_solve_quotes($this->posts->$field, $field);
            }
        }


        //daca tipul recordului este acelasi cu cel curent scote-l din post
        if($this->format == $_POST['idFormat']) {
            unset($this->posts->idFormat);
        }

        // din setarile blogului
        if ($this->blog->status_recordTags) {
            $this->posts->recordTags = $this->Get_validTags($this->posts->recordTags);
        }

       /* if($this->posts->authors){
            $this->posts->authors = explode(',', $this->posts->authors);
        }*/

        // daca nu a venit nici un story related atunci i-al din defaultul recordului
        if(!$this->posts->relatedStory && $_POST['relatedStory_dummy'])  {
            $this->posts->relatedStory = $this->relatedStory;

        }
        if(!$_POST['relatedStory_dummy']) {
            // daca a venit si totusi relatedStory_dummy inseamna ca se doreste
            //deletul acestui recordRelated
            $this->posts->relatedStory = '';
        }

    }
    function updateRecord_validData(&$posts, &$postsConf)
    {
        $validStat = true;


        $validStat &= !empty($posts->title) ? true :
                       $this->fbk->SetGet_badmessFbk(
                           $postsConf['title']['fbk_notempty']
                       );

        $validStat &= !empty($posts->content) ? true :
                        $this->fbk->SetGet_badmessFbk(
                            $postsConf['content']['fbk_notempty']
                        );


        $validStat &= !empty($posts->lead) ? true :
                       $this->fbk->SetGet_badmessFbk(
                           $postsConf['lead']['fbk_notempty']
                       );

        return $validStat;


    }
    function updateRecord_userRights()
    {
        /*use from yml: blogPests_updateRecord */
        if (!$this->blog->Get_rights_articleEdit($this->uidRec, $this->uids)) {
            return $this->fbk->SetGet_badmess(
                        'error',
                        'Not allowed to edit',
                        'your are not the author of this article!!! ');
                        //."<br> your userID = {$this->user->uid} recorUserdID = $this->uidRec");
        }
        /**
         * Rules:
         *
         * 2. daca userul nu are drepturi de editare al recordurilor
         *    - nu are drepturi de moderator si deci de css si js
         *    - nu are dreptul de a schimba data publicarii unui articol
         *
         * 3. daca userul nu are drepturi de publicare atunci nu poate sa isi schimbe
         * data publicarii
         */
        if(!$this->user->rights['article_edit']) {
           unset($_POST['scripts']);
           unset($_POST['publishDate']);

        } else {
            if($_POST['publishDate'] != $this->publishDate) {
                $_POST['republish'] = 1;
            }
            if(isset($_POST['scripts'])) {
                $_POST['scripts'] = base64_encode(trim($_POST['scripts']));
            }
        }

        return true;

    }
    function updateRecord_directLinkRes(){
        $filename  = $_FILES['resHtml']['name'];
        $tmpname  = $_FILES['resHtml']['tmp_name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $resPath   = $this->C->Module_Get_pathRes($this->C->blog, $filename, '', '');
        $resUrl   = str_replace(RES_PATH, RES_URL, $resPath);

        //echo "<b>Check Fisier </b>";

        //validare fisier uploadat
        if (!preg_match("`^[-0-9A-Z_\.]+$`i",$filename)){
            echo "preg_match false<br>";
            return false;
        }
        if (mb_strlen($filename,"UTF-8") > 225){
            echo "mb_strlen false<br>";
            return false;
        }
        if($extension != 'html'){
            echo "extension false<br>";
            return false;
        }
        //echo "Fisier ok <br>";

        //mutarea fisierului in RES
        move_uploaded_file($tmpname, $resPath);

        //inserare in post pentru baza de date
        $_POST['directLink'] = $resUrl;


        return true;
    }
    function _hook_updateRecord()
    {
        //echo "<b>blog_dbHandlers</b>  _POST";

        // valideaza drepturile userului pe datele venite
        if(!$this->updateRecord_userRights()) {
            return false;
        }

        //proceseaza fis de upload if any
        //echo "Check Primit fisier ";
        //var_dump($_FILES);

        if(isset($_FILES['resHtml']) && $_FILES['resHtml']['name']){
            //echo "Primit fisier";
            if(!$this->updateRecord_directLinkRes()) {
                return false;
            }
        }
        //var_dump($_FILES);
        //var_dump($_POST);

        // preia datele din post
        $postsConf =&$this->blog->posts_updateRecord;
        $this->posts = handlePosts::Get_postsFlexy($postsConf, '', false);
        $this->posts->authors = $_POST['authors'];

        // nu mai are rost sa procesam datele daca sunt invalide
        if (!$this->updateRecord_validData($this->posts, $postsConf)) {
            return false;
        }

        // proceseaza si altereaza datele
        $this->updateRecord_processData($this->posts);
        //echo "nr de autori ".count($this->posts->authors);
        //var_dump($this->posts->authors);


        //var_dump($this->posts);
        //return false;
        return true;
    }

    /**
     * updateaza autorii pentru un articol
     *
     * 1. inaini ii delelteaza pe toti
     * 2. apoi ii adaugat din nou
     * @param $idRecord
     */
    function update_authors($idRecord){

        $query_delete = "DELETE FROM blogRecords_authors WHERE idRecord = '{$idRecord}' ";
        //echo $query_delete."<br>";
        $this->DB->query($query_delete);

        foreach($this->posts->authors AS $authId) {
            $query_insert = "INSERT INTO blogRecords_authors (idRecord, uid ) VALUES ('{$idRecord}','{$authId}')  ";
            //echo $query_insert."<br>";
            $this->DB->query($query_insert);
        }

    }
    function update_blogTags($idRecord)
    {

        $query_delete  = "DELETE from blogMap_recordsTags WHERE idRecord = '{$idRecord}'";
        $this->DB->query($query_delete);
        // echo "<br>".$query_delete."<br>";

        foreach($this->posts->recordTags AS $tag){

            $query_insert  = "INSERT INTO blogMap_recordsTags ( idRecord, tagName ) VALUES ('{$idRecord}','{$tag}')";
            $query_replace = "REPLACE INTO blogTags (tagName) values ('{$tag}')          ";
            //echo $query_insert."<br>";
            //echo $query_replace."<br>";

            $this->DB->query($query_insert);
            $this->DB->query($query_replace);
        }

    }
    function updateRecord()
    {

        $posts = &$this->posts;
       // echo "AblogHandler_record - updateRecord()";
        //var_dump($posts);
        //=================================[ update tags ]======================
        if (isset($posts->recordTags) && is_array($posts->recordTags) && count($posts->recordTags > 0)) {
            $this->update_blogTags($posts->idRecord);
        }
        //================================[  update authors ]===================
        if (count($posts->authors) > 0 || count($this->authors) > 0) {
           $this->update_authors($posts->idRecord);
        }

        $queries = array();
        //==============================[ update main blogRecords ]=============
        $columns = 'idCat, title, uidRec';
        $sets = handlePosts::Db_Get_setString($this->posts, $columns);
        $query = "UPDATE blogRecords SET {$sets}
                  WHERE idRecord = '{$posts->idRecord}' ";
        $queries['blogRecords_req'] = $query;

        error_log("[ ivy ] blog_dbHandlers blogRecords query = ".$query);

        //==============================[ update main blogRecords ]=============
        $columns = 'content, lead, sideContent, leadSec, city, country, scripts, directLink, skipIndex';
        $sets = handlePosts::Db_Get_setString($this->posts, $columns, false);
        $query = "UPDATE blogRecords SET {$sets}
                  WHERE idRecord = '{$posts->idRecord}' ";
        $queries['blogRecords'] = $query;

        error_log("[ ivy ] blog_dbHandlers blogRecords query = ".$query);


        //==============================[ update blogRecords_stats ]============
        $columns = 'publishDate, republish';
        $sets = handlePosts::Db_Get_setString($this->posts, $columns);
        if($sets) {
            $query = "UPDATE blogRecords_stats SET {$sets}
                      WHERE idRecord = '{$posts->idRecord}' ";
            $queries['blogRecords_stats'] = $query;

            error_log("[ ivy ] blog_dbHandlers blogRecords_stats query = ".$query);

        }


        //=======================[ update blogRecords_settings ]================
        $columns = 'idFormat, idFolder, css, js, relatedStory' ;
        //$columns = 'idFormat, idFolder, css, js' ;
        $sets = handlePosts::Db_Get_setString($this->posts, $columns, false);
        if ($sets) {
            $query = "UPDATE blogRecords_settings SET $sets
                     WHERE idRecord = '{$posts->idRecord}' ";
            $queries['blogRecords_settings'] = $query;

            error_log("[ ivy ] blog_dbHandlers blogRecords_settings query = ".$query);

        }

        //print_r($queries);
        //var_dump($this->posts);
        /*var_dump($_POST);
        foreach($queries AS $table => $query) {
            echo "<br><br><b>table = $table query = </b> <br> $query ";
        }
       return false;*/

       $this->C->Db_queryBulk($queries, false);
       return true;

    }


    function  publish()
    {
        /**
         * butoanele de publish nu se vor afisa daca userul nu are permisiuni de publicare
         */
        $idRecord      =   $_POST['BLOCK_id'];
        $query = "UPDATE blogRecords_stats SET publishDate = NOW() WHERE idRecord = '{$idRecord}' ";
        //echo $query;
        $this->DB->query($query);
        return true;
    }
    function  unpublish()
    {
        $idRecord      =   $_POST['BLOCK_id'];
        $query = "UPDATE blogRecords_stats SET publishDate = NULL WHERE idRecord = '{$idRecord}' ";
        $this->C->Db_query($query);
        #echo $query;
        return true;

    }
    function _hook_deleteRecord()
    {
        if (!$this->blog->Get_rights_articleEdit($this->uidRec, $this->uids)) {
            return $this->fbk->SetGet_badmess(
                        'error',
                        'Not allowed to delete',
                        'your are not the author of this article!!! ');
                        //."<br> your userID = {$this->user->uid} recorUserdID = $this->uidRec");
        }
        return true;
    }
    function  deleteRecord()
    {
        $idRecord = $_POST['BLOCK_id'];

        $query = "DELETE FROM blogRecords WHERE idRecord = '{$idRecord}' ";
        $result = $this->DB->query($query);
        if($result) {
            $this->C->feedback->Set_mess(
                      'Succes',
                      'Deleted',
                      'your article was succesfully deleted!!!');
            $this->C->reLocate("?idT={$this->idTree}&idC={$this->idNode}");
            return true;
        } else {
            return $this->C->feedback->Set_badmess(
                      'error',
                      'Not allowed to remove this article',
                      'your are not the author of this article
                      and do not have permisiion to delete it!!!');
        }

   }

    // configurare Ablog.js ( pt butoanele de la EDITmode)
    function jsConfig(){
        $this->C->jsTalk .="
           ivyMods.blogConf = {
                article_pub : ".$this->user->rights['article_pub'].",
                publishStatus: '".$this->publishDate."'
           };
        ";

    }
    function _init_()
    {
        parent::_init_();
        $this->fbk = &$this->C->feedback;
        $this->user     = &$this->C->user;
        $this->jsConfig();
    }

}
