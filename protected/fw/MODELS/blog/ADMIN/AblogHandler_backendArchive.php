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

class AblogHandler_backendArchive extends blogHandler_archive
{
    var $recordsUnpublished;

    function _hookRow_archive($row)
    {
        $row = parent::_hookRow_archive($row);
        $row['EDrecord']      = $this->rowDb->Get_recordED($row['uidRec'], $row['uids']);
        $row['statusPublish'] = $this->rowDb->Get_publishedStatus($row['publishDate']);

        return $row;

    }

    function archive_setData()
    {
        $filters = array('category' => "{$this->idNode}");
        if($this->C->user->uclass != 'admin') {
            $filters['auth'] = $this->C->user->uid;
        }
        $this->sqlRecords = $this->baseQuery->Get_queryRecords($filters);
        $query = $this->sqlRecords->fullQuery.' ORDER BY publishDate DESC, idRecord DESC';
        $this->records = $this->C->Db_Get_procRows($this, '_hookRow_archive', $query);

        // unpublished records
        // set by the parent  $this->sqlRecords
        $this->recordsUnpublished =  $this->blog->unpublished_getData(
            $this->sqlRecords, $this,  '_hookRow_archive');
    }
    function _init_()
    {
        $this->archive_setData();
        $this->C->siteTitle = $this->tree[$this->idTree]->name;
    }

}