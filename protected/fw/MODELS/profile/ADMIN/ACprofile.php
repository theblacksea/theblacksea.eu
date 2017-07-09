<?php
/**
 * Permissions used:
 *
 *user->rights = array (size=21)
 *
   'gid' => boolean true
   'comm_save'
   'comm_edit'
   'comm_pub'
   'comm_rm'
   'article_edit'   // to edit an article means to : edit / save
   'article_save'   // este destul de pointles pentru ca daca editezi si nu potzi salva nu are nici un sens
   'article_pub'
   'article_rm'
   'mute_user'
   'page_add'
   'page_edit'
   'page_pub'
   'page_rm'
   'user_add'
   'user_edit'
   'user_rm'
   'group_add'
   'group_edit'
   'group_rm'
   'perm_manage'
 *
 * used like :$this->user->rights['article_edit']
 *
 * uclass = [ root, guest, subscriber, moderator, editor,
 *           publisher, webmaster, admin ]
 *
 */

class ACprofile extends Cprofile
{
    public  $post;   // obiect cu posturile asteptate
    public  $user;    // pointer to Cuser
    public  $fbk;     // pointer to Cfeedback
    public  $toolbar; // pointer to ACTOOLbar
    // db methods

     // add user
    function Set_addUserData(){

        $this->profile = new stdClass();
        $this->profile->photoSrc = 'RES/uploads/foto/default_avatar.png';
        $this->Set_classes();
    }
    function _hook_addUser(){
        if(!$this->_hook_adminRights()){
            return false;
        }

        $postExpected = &$this->post_addUser;
        $this->post   = handlePosts::Get_postsFlexy($postExpected);
        $posts        = &$this->post;
        //validation
        //$validation = $this->validatePostsAddUser($posts);
        $validation = handlePosts::process_postsFlexy($posts, $postExpected, $this->fbk);

        /**
         * The uname validation to see if it allready exists or not should be done
         * async.
         */
        $fbks = &$this->fbks;
        $validation &= !$this->post->uname
            ? $this->fbk->SetGet_badmessFbk($fbks['emptyUname'])
            : ( $this->valid_uname($this->post->uname)
                ? true
                : $this->fbk->SetGet_badmessFbk($fbks['takenUname'])
            )  ;

        if(!$validation) return false;

        $posts->photo = str_replace(BASE_URL, '', $posts->photo);
        $posts->photoQuery = !$posts->photo ? '' :
                             ", photo      = '{$posts->photo}' ";

        /*echo !$this->post->uname ? "nu userName" : "there i a uerName";
        echo "ACblogSite - _hook_addProfile: ".BASE_URL
            ."<br>"
            ."_POST" ;
        var_dump($_POST);
        echo "ACblogSite - _hook_addProfile: validation = ".($validation ? "true" :  "false")."<br>";
        echo "this->post";
        var_dump($this->post);
        return false;*/
        return $validation;

    }
    function addUser(){
        $query_insertUser  = "
         INSERT INTO auth_users (cid, name, active, email, password)
                     VALUES ('{$this->post->cid}', '{$this->post->uname}', '1',
                             '{$this->post->email}', md5('{$this->post->password}') )
        ";

        //$newId = 0;
        $this->DB->query($query_insertUser);
        $newId = $this->DB->insert_id;
        //echo $query_insertUser."<br>";

        $query_userDetails = "
            INSERT INTO auth_user_details
             SET
                first_name = '{$this->post->first_name}',
                last_name  = '{$this->post->last_name}',
                title      = '{$this->post->title}',
                site       = '{$this->post->site}',
                phone      = '{$this->post->phone}',
                bio        = '{$this->post->bio}',
                uid        = {$newId}
                {$this->post->photoQuery}
             ";

        $this->DB->query($query_userDetails);
        //echo $query_userDetails."<br>";
        $query_user_stats = "INSERT INTO auth_user_stats (uid) VALUES ('$newId')";
        $this->DB->query($query_user_stats);
        //echo $query_user_stats."<br>";

        Toolbox::relocate(PUBLIC_URL."/?mgrName=profile&uid={$newId}");
        return false;
        //return true;
    }

    // admin methods
    function _hook_change_activeStatus()
    {
        $adminPerms = $this->_hook_adminRights();
        if(!$adminPerms){
            return false;
        }
        //=============================================[ data validation ]======

        $postExpected = &$this->post_adminActiveStat;
        $this->post = handlePosts::Get_postsFlexy($postExpected);

        //Debugging
        //echo "ACprofile -_hook_change_activeStatus posts" ;
        //var_dump($_POST);
        // echo "ACprofile -_hook_change_activeStatus postExpected" ;
        // var_dump($postExpected);
        // echo "ACprofile -_hook_change_activeStatus : $validation" ;
        //echo "ACprofile -_hook_change_activeStatus : posts" ;
        // var_dump($this->post);
         return true;

        //return $validation;


    }
    function change_activeStatus()
    {
        parent::change_activeStatus($this->post->uid, $this->post->activeStatus);
        return true;
    }

    function _hook_saveProfileAdmin()
    {
        //==============================================[ rights validation ]===
        $fbks = &$this->fbks;
        $adminPerms = $this->_hook_adminRights();
        if(!$adminPerms){
            return false;
        }
        //=============================================[ data validation ]======
        $postExpected = &$this->post_adminProfile;
        $this->post = handlePosts::Get_postsFlexy($postExpected);
        $validation = handlePosts::process_postsFlexy($this->post, $postExpected, $this->fbk);

        /**
         * Daca numele userului a fost schimbat
         * daca nu nu are rost sa se mai faca teste
         */
        if($this->post->uname != $this->profile->uname)
        {
            /**
             * The uname validation to see if it allready exists or not should be done
             * async.
             */
            $validation &= !$this->post->uname
                ? $this->fbk->SetGet_badmessFbk($fbks['emptyUname'])
                : ( $this->valid_uname($this->post->uname) ? true :
                    $this->fbk->SetGet_badmessFbk($fbks['takenUname'])
                )  ;
        }
        return $validation;
    }
    function saveProfileAdmin()
    {
        /**
         * salvare cid si username
         * vom avea change_uclass
         * si change_uName
         */
        if($this->post->uname != $this->profile->uname) {
            $this->change_uclass($this->profile->uid, $this->post->uname);
        }
        if($this->post->cid != $this->profile->cid) {
            $this->change_uclass($this->profile->uid, $this->post->cid);
        }

        return true;
    }

    // user methods
    function _hook_saveProfile()
    {
        $validation = true;
        $postExpected = &$this->post_profile;

        $this->post = handlePosts::Get_postsFlexy($postExpected);
        $posts = &$this->post;

        $validation &= handlePosts::process_postsFlexy($posts, $postExpected, $this->fbk);
        $validation &= $this->Get_rightsProfile($posts->uid) ? true :
                       $this->fbk->SetGet_badmessFbk($postExpected['uid']['fbk']);

        if(!$validation) return false;

        $posts->photo = str_replace(BASE_URL, '', $posts->photo);
        $posts->photoQuery = !$posts->photo ? '' :
                             ", photo      = '{$posts->photo}' ";

        // echo "ACblogSite - _hook_saveProfile: ".BASE_URL."<br>";
        // var_dump($_POST);
        // echo "ACblogSite - _hook_saveProfile: validation = ".($validation ? "true" :  "false")."<br>";
       // var_dump($this->post);
        //return false;
        return $validation;
    }
    function saveProfile()
    {
        $query_userDetails = "
            UPDATE auth_user_details
             SET
                first_name = '{$this->post->first_name}',
                last_name  = '{$this->post->last_name}',
                title      = '{$this->post->title}',
                site       = '{$this->post->site}',
                phone      = '{$this->post->phone}',
                bio        = '{$this->post->bio}'
                {$this->post->photoQuery}
             WHERE
                 uid = {$this->post->uid}
        ";

        $query_updateUser  = "
            UPDATE auth_users
            SET
              email = LOWER('{$this->post->email}')
            WHERE
                 uid = {$this->post->uid}
        ";

        //echo "ACblogSite - saveProfile query_userDetails = $query_userDetails <br>";
        //echo "ACblogSite - saveProfile query_updateUser = $query_updateUser <br>";

        $this->DB->query($query_userDetails);
        $this->DB->query($query_updateUser);

        //return false;
        return true;
    }

    function _hook_deleteUser()
    {
        $adminPerms = $this->_hook_adminRights();
        if(!$adminPerms){
            return false;
        }
        //=============================================[ data validation ]======

        $postExpected = &$this->post_adminActiveStat;
        $this->post = handlePosts::Get_postsFlexy($postExpected);

        echo $this->post->uid;
        //return false;
        return true;
    }
    function deleteUser()
    {
         parent::deleteUser($this->post->uid);
    }

    // view methods
    function _hook_adminRights(){

        //==============================================[ rights validation ]===
        $adminPermss = $this->Get_rightsProfileAdmin();
        $fbks = &$this->fbks;
        if(!$adminPermss) {

            $this->fbk->Set_messFbk($fbks['noRights']);
            return false;
        }
        return true;

    }

    function Get_rightsProfileAdmin()
    {
        return $this->user->uclass == 'webmaster' || $this->user->rights['user_edit'] ;
    }
    function Get_rightsProfile($uid)
    {
        // var_dump($this->user->rights);
        $permision = ( $uid == $this->user->uid
                    || $this->user->rights['user_edit']
                    || $this->user->uclass == 'webmaster');

        //echo "ACblogSite - Get_rightsProfile: $uid = {$this->user->uid} <br>";
        /*echo "ACblogSite Get_rightsProfile :"
             .($permision
                ? 'Userul are Permisiuni de editare'
                : 'Userul Nu are Permisiuni de editare')
              ."<br>";*/
        //return $permision;
        return $permision;
    }

    function _hookRow_userData($row)
    {
        $row = parent::_hookRow_userData($row);
        // echo "ACblogSite - _hookRow_profileData  <br>";
        $row['editStatus'] = $this->Get_rightsProfile($row['uid']) ? '' : 'not';
        $row['editStatusAdmin'] = $this->Get_rightsProfileAdmin($row['uid']) ? "true" : "false";

        return $row;
    }
    function Set_userData($uid)
    {
        $this->Set_classes();
        parent::Set_userData($uid);
        $this->C->jsTalk .="
                   ivyMods.profileConf = {
                        editStatusAdmin : ".$this->profile->editStatusAdmin.",
                        activeStatus: ".$this->profile->active."
                   };
            ";

    }
    function _hookRow_aboutData($row){
        $row = parent::_hookRow_aboutData($row);
        $row['editStatus'] = $this->Get_rightsProfile($row['uid']) ? '' : 'not';
        return $row;
    }
    // about page
    function Set_aboutData()
    {
        parent::Set_aboutData();
         // editors only for admin , webmasters & moderators
        if($this->user->cid <= 3) {

            // editors
            $sql  =
               $this->C->Db_Get_queryParts($this, 'Get_preProfileQuery', array('editors' => ''));

            $this->editors =
                $this->C->Db_Get_procRows($this, '_hookRow_aboutData', $sql->query);
               // echo "<b>Cprofile - Set_aboutData</b> : editors cu queriul <br> {$sql->query}";
                //var_dump($this->editors);
        }
    }

    public  function Set_toolbarButtons()
    {
        array_push($this->toolbar->buttons,"
            <a href='' >
                anyButton
            </a>
        ");
    }
    function _init_()
    {
        //echo "ACblogSite - _init_<br>";

        $this->toolbar = &$this->C->TOOLbar;
        $this->user = &$this->C->user;
        $this->fbk = &$this->C->feedback;
       // $this->Set_toolbarButtons();
        parent::_init_();
    }
}
