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
class AblogHandler_backendBlog extends blogHandler_blog
{
    var $recordsUnpublished;

    function _hookRow_blog($row)
    {

        $row = parent::_hookRow_blog($row);
        $row['EDrecord']      = $this->rowDb->Get_recordED($row['uidRec'], $row['uids']);
        $row['statusPublish'] = $this->rowDb->Get_publishedStatus($row['publishDate']);

        return $row;
    }
    function blog_setSqlRecords(){
        $filters = array('category' => "{$this->idNode}");
        if($this->C->user->uclass != 'admin') {
            $filters['auth'] = $this->C->user->uid;
        }
        $this->sqlRecords = $this->baseQuery->Get_queryRecords($filters);
    }
    function blog_setData()
    {
        parent::blog_setData();
        // unpublished records
        // set by the parent  $this->sqlRecords
        $this->recordsUnpublished =  $this->blog->unpublished_getData(
            $this->sqlRecords, $this,  '_hookRow_blog');
    }

}