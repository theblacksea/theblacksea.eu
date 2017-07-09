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

class blogHandler_search extends ivyModule_objProperty
{
    // records list
    var $records;

    // archive.html - filters
    var $formatFilters ;
    var $tagFilters     ;
    var $countryFilters;
    /**
     * @var array(
     * 'filterName' => array(
     *  'filterName' => ''
     *  'filterValue' => ''
     *  'filterDesc' => ''
     *  'filterHref' => 'filterName={$filterName}&filterValue={$filterValue}'
     * ))
     */
    var $idFolderFilters  ;

    var $cls_selectedFilter = array(0=>'', 1=>'filter-selected');
    var $cls_selectedFilters = 'filters-selected';
    /**
     * @var array ex: array('format'=>'filters-selected',
     *                       'tag'=>'',
     *                       'country'=>'',
     *                       'idFolder'=>'');
     */
    var $filtersSets_selectedStat = array('format'=>'',
                                          'tag'=>'',
                                          'country'=>'',
                                          'idFolder'=>'');

    //mans
    var $sqlRecords;

   // pointers
    var $blog;
    var $baseQuery;
    var $filters;
    var $rowDb;
    var $quotesProblemsFields = array('content', 'lead', 'leadSec', 'title');

    var $searchWords = array();


    function _hookRow_search($row)
    {
        /**
         * RET DATA from DB - to process
         *
         * [ TB blogRecords_view]
           idRecord,
           idCat,uidRec,entryDate,publishDate,nrRates,ratingTotal,
           title,content,lead,
         *
         * [ TB blogRecords_settings ]
           format,modelComm_name,commentsView,commentsStat,commentsApprov,SEO,

         * [ TB blogMap_recordsTags ]
           uid_Rec, fullName,

         * [ TB blogMap_recordsTags]
           tagsName
        */
        /**
         * daca formatul paginii este de tip link
         * si linkul se afla in leadul articolului
         * si nu este activat live edit
         * => linkul la articol va fi chiar leadul articolului
         * => leadSec va ramane asa cum este => trebuie pus leadSec/ preview lead
         *
         * pentru a avea un preview lead la articol
         *
         */
        $linkPage = $row['format'] == 'link'
                    && $row['lead']
                    && !$_SESSION['activeEdit'];

        if($linkPage){
            $row['record_href']      =  strip_tags($row['lead'])."' target='_blank";
        } else {
            $row['record_href']      = $this->rowDb->Get_record_href($row);
        }

        foreach($this->quotesProblemsFields AS $field){
            if($row[$field]) {
                $row[$field] = $this->rowDb->GET_solve_quotes($row[$field]);
            }
        }

        //------------for search
        $row['title']   = $this->rowDb->Get_highlightWords($row['title'], $this->searchWords);
        $row['lead']    = $this->rowDb->Get_highlightWords($row['lead'], $this->searchWords);

        $row['content'] = $this->rowDb->Get_contentWithoutImages($row);
        $row['content'] = $this->rowDb->Get_highlightWordsParts($row['content'], $this->searchWords, 'content');


        #var_dump($row);
        return $row;
    }
    function search_setData()
    {
        /**
         * Setted data:
         * ->records
         *
         * + idRecord
         * + idCat
         * + uidRec
         * + entrydate
         * + publishDate
         * DEP + nrRates
         * DEP + ratingTotal
         * + title
         * + content
         * + lead
         * + leadSec
         * + country
         * + city
         * + format
         * + modelComm_name
         * + commentsView
         * + commentsApprov
         * + SEO
         * + uid_Rec
         * + fullName
         * + tagsName
         *
         * processed data
         * + record_mainPic
         * + record_href
         * + ReadMore_link
         * + EDrecord
         *
        */
        //$this->sqlRecords   = $this->baseQuery->Get_queryRecords(array('category' => ''));
        $queryAllWords = $this->baseQuery->Get_queryRecords(
                            array('searchAll' => $_REQUEST['searchText']));

        $queryMinWords = $this->baseQuery->Get_queryRecords(
                            array('searchMin' => $_REQUEST['searchText']));

        /*$this->sqlRecords = $this->baseQuery->Get_queryRecords(
                                array('searchAll' => $_REQUEST['searchText']));*/

        //$query = $this->sqlRecords->fullQuery.' ORDER BY publishDate DESC, idRecord DESC';

        $query = "( "
                 . $queryAllWords->fullQuery.' ORDER BY publishDate DESC, idRecord DESC'
                 . " ) UNION ("
                 . $queryMinWords->fullQuery.' ORDER BY publishDate DESC, idRecord DESC'
                 . " )";


        //$query =$queryMinWords->fullQuery.' ORDER BY publishDate DESC, idRecord DESC';

        $this->records = $this->C->Db_Get_procRows($this, '_hookRow_search', $query);
        //echo "blog_handlers - archive_setData : this->records";
        //echo "nr Records = ".count($this->records);
        //echo "<br>{$query}<br>";
        //var_dump($this->records);
    }

    function set_searchWords($searchString){
         $searchString = explode(" ", $searchString);
        foreach($searchString AS $searchWord) {
            $searchWord = trim($searchWord);
            array_push($this->searchWords, $searchWord);
        }
    }
    function _init_()
    {
        if(isset($_REQUEST['searchText']) && $_REQUEST['searchText']) {
            $this->set_searchWords($_REQUEST['searchText']);
            $this->search_setData();
        } else {
            echo "you have no search words";
        }
        $this->C->siteTitle = "The BlackSea";
    }

}