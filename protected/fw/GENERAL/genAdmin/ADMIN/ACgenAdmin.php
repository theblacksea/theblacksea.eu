<?php
class ACgenAdmin {

    /**
     * $items = [
        id = ITEMS.id
     *  name = ITEMS.name_en
     *  manager = ITEMS.type
     *  parents = array(TREE.Pid,...)
     *  menus = array( MENUS.idM join MENUS.id ..)
     *  edit = ?mgrName=genAdmin&idItem= id
     * ];
     *
     */
    public $items;
    public $fbk; // pointer from core
    public $managers;

    public $settings = array(
        "homePic" =>"",
        "homeLink" => ""
    );

    function getSettings(){
        $query = "SELECT * from general_settings";
        $res = $this->DB->query($query);
        while($row = $res->fetch_assoc()){
            $setting = $row['setting'];
            $value = $row['value'];
            $this->settings[$setting] = $value;
        }
    }

    function updateSettings(){
       foreach($this->settings AS $setting => $val){
           if(isset($_POST[$setting]) && $_POST[$setting]!=''){
               $value =trim($_POST[$setting]);
               $query = "UPDATE general_settings
                            SET value = '{$value}' WHERE setting = '{$setting}' ";
               $this->C->Db_query($query);
           }
       }
    }

    function jsSortItems(){
        $node = $_POST['idC'] ?: 0;

        //UPDATE TREE
        $queries = array();
        //$test ='';
        foreach($_POST['sorted'] AS $key=>$value){
            $item = explode("_",$value);
            $id = $item[1];

            $query = "UPDATE TREE SET poz = $key WHERE Pid=$node AND Cid=$id";
            array_push($queries, $query);
            //$test .= $query." | ";
            $this->C->Db_queryBulk($queries);
        }
        //echo $test;

        //RESET ALL TREES
        $this->C->resetAllTrees();
        $this->C->regenerateAllTrees();

        //resetMenus
        Cmodules::FS_deleteContentRes(RES_PATH.'PLUGINS/ivyMenu');

    }

    function _hook_allPosts($postExpected, $postName='post', $notEmpty = false){
        $this->$postName = handlePosts::Get_postsFlexy($postExpected,'',$notEmpty);
        $validation = handlePosts::process_postsFlexy($this->$postName, $postExpected, $this->fbk);

        return $validation;
    }

    function _hook_deleteItem(){
        $validation = $this->_hook_allPosts($this->deleteItemForm);
        //var_dump($this->post);
        //echo "validation = $validation";
        //return false;
        return $validation;
    }
    function deleteItem(){
        //delete from ITEMS
        $query = "DELETE FROM ITEMS WHERE id = {$this->post->idItem}";
        $this->C->Db_query($query);

        //delete from TREE
        $this->C->resetAllTrees();
        $this->C->regenerateAllTrees();
        //delete from menus if necesary
        Cmodules::FS_deleteContentRes(RES_PATH.'PLUGINS/ivyMenu');

        return true;
    }

    function _hook_updateItem(){
        $validation = $this->_hook_allPosts($this->updateItemForm);

        //options processing
        $_POST = $_POST['options'];
        $validation &= $this->_hook_allPosts($this->updateItemFormOption, "postOpt", true);

        $this->post->optionsSql = $this->procesOptions();
        //var_dump($_POST);
        //var_dump($this->post);
        //return false;
        return $validation;
    }
    function procesOptions(){
        $postOpt = (array) $this->postOpt;
        $postOptContent = implode('', $postOpt);
        if(count($postOpt) > 0 && $postOptContent){
            return ", opt = '".json_encode($postOpt)."' ";
        } else {
            return "";
        }

    }
    function updateItem(){
        //update ITEM
        $query = "UPDATE ITEMS
                    SET
                        name_en = '{$this->post->name_en}',
                        name_ro = '{$this->post->name_en}',
                        type    = '{$this->post->type}'
                        {$this->post->optionsSql}
                    WHERE
                        id = {$this->post->id}
        ";
        $this->C->Db_query($query);

        //update TREE + delete trees & regenerate them
        //count to see how many children that parent has. To know the next position
        //although this is is not really accurate. But will see..
        $query = "SELECT * from TREE WHERE Pid = {$this->post->idP}";
        $result = $this->DB->query($query);
        $poz = $result->num_rows;

        $query = "UPDATE TREE
                    SET
                      Pid = {$this->post->idP},
                      poz = $poz
                    WHERE
                      Cid = {$this->post->id}
                    ";
        $this->C->Db_query($query);
        $this->C->resetAllTrees();
        $this->C->regenerateAllTrees();

        //menus
        // ATENTIE!!! e problema aici daca exista mai multe meniuri
        $query = "DELETE from MENUS WHERE id={$this->post->id}";
        //echo $query."<br>";
        $this->C->Db_query($query);
        if($this->post->idM){
            $query = "INSERT into MENUS SET
                        id = {$this->post->id},
                        idM = 1";
            //echo $query."<br>";

            $this->C->Db_query($query);
        }
        //regenerate menu, ar putea exista cazuri cand nu este
        //nevoie de asa ceva -> better safe than sorry
        Cmodules::FS_deleteContentRes(RES_PATH.'PLUGINS/ivyMenu');

        return true;
    }

    function _hook_addItem(){
        $validation = $this->_hook_allPosts($this->addItemForm);

        //var_dump($this->post);
        //return false;
        return $validation;


    }
    function addItem(){
        /**
         * Expected posts to work with
         * addItemForm:
           name_en:
             sanitize: *id001
             validation:
               0: {check: "notEmpty", type: "error", name: "Empty Page Name", mess: "Please enter a page name"}
               1: {check: "alpha", type: "error", name: "Page Name", mess: "Containes unallowed characters"}
           type: []
           idP:
             postName: "idParent"
         */
        //add ITEM to ITEMS
        $query = "INSERT into ITEMS SET
                    name_en = '{$this->post->name_en}',
                    name_ro = '{$this->post->name_en}',
                    type    = '{$this->post->type}'

        ";
        $this->C->Db_query($query);
        $insertID = $this->DB->insert_id;

        if(!$insertID){
            return false;
        }

        /**
         * If it has parents than the trees should be deleted AND the
         * item should be inserted in the TREE table
         */
        $poz = 0;
        if($this->post->idP!=0){
            //delete all reses of the trees;
             $this->C->resetAllTrees();

             //count to see how many children that parent has. To know the next position
             //although this is is not really accurate. But will see..
             $query = "SELECT * from TREE WHERE Pid = {$this->post->idP}";
             $result = $this->DB->query($query);
             $poz = $result->num_rows;

        }

        $query = "INSERT into TREE SET
                        Pid = {$this->post->idP},
                        Cid = $insertID,
                        poz = $poz";
        $this->C->Db_query($query);

        if($this->post->idP!=0){
            $this->C->regenerateAllTrees();
        }

        /**
         * If we chose a menu for the item then update the MENUS table
         * Also the RES for the menu should be deleted
         */
        if($this->post->idM){
            $query = "INSERT into MENUS SET
                        id = $insertID,
                        idM = 1";
            $this->C->Db_query($query);
        }
        //regenerate menu, ar putea exista cazuri cand nu este
        //nevoie de asa ceva -> better safe than sorry
        Cmodules::FS_deleteContentRes(RES_PATH.'PLUGINS/ivyMenu');

        return true;
    }

    function setManagers(){
        $this->managers = array_merge($this->C->MODELS, $this->C->LOCALS);
    }
    function setItems($idP = 0){

        $query = "SELECT id, name_en
                    from ITEMS
                    LEFT OUTER JOIN TREE ON(TREE.Cid = ITEMS.id)
                    ORDER BY poz ASC";
        $this->allItems = $this->C->Db_Get_rows($query);

        $query = "SELECT *
                    from ITEMS
                    LEFT OUTER JOIN TREE ON(TREE.Cid = ITEMS.id)
                    WHERE Pid = $idP
                    ORDER BY poz ASC
                ";

        //echo $query;
        $queryRes = $this->C->Db_Get_queryRes($query);

        $items = array();
        while ($item = $queryRes->fetch_assoc()){
            $item['options'] = $item['opt'] ? json_decode($item['opt']) : array();
            $id = $item['id'];
            $query = "SELECT
                          GROUP_CONCAT( ITEMS.name_en SEPARATOR ',') AS parentNames,
                          GROUP_CONCAT( TREE.Pid SEPARATOR ',') AS parentIds
                      from ITEMS
                      LEFT OUTER JOIN TREE ON(TREE.Pid = ITEMS.id)
                      WHERE Cid = $id
                      GROUP BY Cid ";
            $parents = $this->C->Db_Get_rows($query);;
            $item['parents'] = $parents[0]['parentNames'] ?: "" ;
            $item['parentsId'] = $parents[0]['parentIds'] ?: 0 ;


            $query = "SELECT
                        GROUP_CONCAT( MENUS.idM SEPARATOR ',') AS menuIds
                      FROM MENUS
                      JOIN ITEMS ON(MENUS.id = ITEMS.id)
                      WHERE MENUS.id = $id
                      GROUP BY ITEMS.id
                      ";
            $menus = $this->C->Db_Get_rows($query);
            $item['menus'] =  $menus[0]['menuIds'] ?: "";

            $item['childrenNo'] = 0;
            if(count($this->mtree[$id]->children) > 0){
                $item['hrefSubtree'] = "?route=genAdmin-listItems&idC={$id}";
                $item['childrenNo'] = count($this->mtree[$id]->children);
                }



           // var_dump($this->mtree);
            $item['editHref'] = "?route={$item['type']}-edit"."&idT=".$this->mtree[$id]->idTree
                                 ."&idC=".$id;
            array_push($items, $item);
        }
        $this->items = $items;
        //var_dump($this->items);

    }
    function listItems(){
        $idParent = isset($_GET['idC']) ? $_GET['idC'] : 0;

        $this->setItems($idParent);
        $this->setManagers();
    }
    function _init_(){
        $this->getSettings();
        $this->fbk = &$this->C->feedback;
    }
}