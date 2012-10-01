<?php

/**
 * DGSphinxSearch extension wrapper to communicate with Sphinx full-text search engine
 * For More documentation please see:
 * http://sphinxsearch.com/
 */
/**
 * @defgroup DGSphinxSearchComponent
 * @version 1.0.1
 */

/**
 * @class DGSphinxSearchException
 * @brief extends default CException
 */
class DGSphinxSearchException extends CException
{

}

/**
 * @class DGSphinxSearch
 * @brief Implements Sphinx Search
 * @details Wrapper for sphinx searchd client class
 *
 * "A" - Team:
 * @author     Andrey Evsyukov <thaheless@gmail.com>
 * @author     Alexey Spiridonov <a.spiridonov@2gis.ru>
 * @author     Alexey Papulovskiy <a.papulovskiyv@2gis.ru>
 * @author     Alexander Biryukov <a.biryukov@2gis.ru>
 * @author     Alexander Radionov <alex.radionov@gmail.com>
 * @author     Andrey Trofimenko <a.trofimenko@2gis.ru>
 * @author     Artem Kudzev <a.kiudzev@2gis.ru>
 *
 * @link       http://www.2gis.ru
 * @copyright  2GIS
 * @license http://www.yiiframework.com/license/
 *
 * Requirements:
 * --------------
 *  - Yii 1.1.x or above
 *  - SphinxClient php library
 *
 * Usage:
 * --------------
 * 
 * Search by criteria Object:
 * 	
 *     $searchCriteria = new stdClass();
 *     $pages = new CPagination();
 *     $pages->pageSize = Yii::app()->params['firmPerPage'];
 *     $searchCriteria->select = 'project_id';
 *     $searchCriteria->filters = array('project_id' => $project_id);
 *     $searchCriteria->query = '@name '.$query.'*';
 *     $searchCriteria->paginator = $pages;
 *     $searchCriteria->groupby = $groupby;
 *     $searchCriteria->orders = array('f_name' => 'ASC');
 *     $searchCriteria->from = 'firm';
 *     $resIterator = Yii::App()->search->search($searchCriteria); // interator result
 *     or
 *     $resArray = Yii::App()->search->searchRaw($searchCriteria); // array result
 *
 *
 * Search by SQL-like syntax:
 *
 *      $search->select('*')->
 *               from($indexName)->
 *               where($expression)->
 *               filters(array('project_id' => $this->_city->id))->
 *               groupby($groupby)->
 *               orderby(array('f_name' => 'ASC'))->
 *               limit(0, 30);
 *      $resIterator = $search->search(); // interator result
 *      or
 *      $resArray = $search->searchRaw(); // array result
 *
 * Search by SphinxClient syntax:
 *
 *      $search = Yii::App()->search;
 *      $search->setSelect('*');
 *      $search->setArrayResult(false);
 *      $search->setMatchMode(SPH_MATCH_EXTENDED);
 *      $search->setFieldWeights($fieldWeights)
 *      $search->query( $query, $indexName);
 *
 *
 * Combined Method:
 *
 *      $search = Yii::App()->search->
 *                            setArrayResult(false)->
 *                            setMatchMode(SPH_MATCH_EXTENDED);
 *      $search->select('field_1, field_2')->search($searchCriteria);
 *                                     ;
 */
if (!class_exists('SphinxClient', false)) {
    include_once(dirname(__FILE__) . '/sphinxapi.php');
}

class DGSphinxSearch extends CApplicationComponent
{

    /**
     * @var string
     * @brief sphinx server
     */
    public $server = 'localhost';
    /**
     * @var integer
     * @brief sphinx server port
     */
    public $port = 6712;
    /**
     * @var integer
     * @brief sphinx default match mode
     */
    public $matchMode = SPH_MATCH_EXTENDED;
    /**
     * @var integer
     * @brief sphinx default rank mode
     */
    public $rankMode = SPH_RANK_SPH04;
    /**
     * @var integer
     * @brief sphinx max exec time
     */
    public $maxQueryTime = 3000;
    /**
     * @var array
     * @brief default field weights
     */
    public $fieldWeights = array();
    /**
     * @var boolean
     * @brief enable Yii profiling
     */
    public $enableProfiling = false;
    /**
     * @var boolean
     * @brief enable Yii tracing
     */
    public $enableResultTrace = false;
    /**
     * @var stdClass
     * @brief current search criteria
     */
    protected $criteria;
    /**
     * @var stdClass
     * @var last used criteria
     */
    protected $lastCriteria;
    /**
     * @var SphinxClient
     * @brief Sphinx client object
     */
    private $client;

    public function init()
    {
        parent::init();
        include_once(dirname(__FILE__) . '/models/DGSphinxSearchResult.php');

        $this->client = new SphinxClient;
        $this->client->setServer($this->server, $this->port);
        $this->client->setMaxQueryTime($this->maxQueryTime);
         Yii::trace("weigth: " . print_r ($this->fieldWeights,true), 'CEXT.DGSphinxSearch.doSearch');
         
        $this->resetCriteria();
    }

    /**
     * @brief connect to searchd server, run given search query through given indexes,
     * and return the search results
     * @details Mapped from SphinxClient directly
     * @param string $query
     * @param string $index
     * @param string $comment
     * @return array
     */
    public function query($query, $index='*', $comment='')
    {
	return $this->doSearch($index, $query, $comment);
    }

    /**
     * @brief full text search system query
     * @details send query to full text search system
     * @param object criteria
     * @return DGSphinxSearchResult
     */
    public function search($criteria = null)
    {
        if ($criteria === null) {
            $res = $this->doSearch($this->criteria->from, $this->criteria->query);
        } else {
            $res = $this->searchByCriteria($criteria);
        }
        return $this->initIterator($res, $this->lastCriteria);
    }

    /**
     * @brief full text search system query
     * @details send query to full text search system
     * @param object criteria
     * @return array
     */
    public function searchRaw($criteria = null)
    {
        if ($criteria === null) {
            $res = $this->doSearch($this->criteria->from, $this->criteria->query);
        } else {
            $res = $this->searchByCriteria($criteria);
        }
        return $res;
    }

    /**
     * @brief set select-list (attributes or expressions), SQL-like syntax - 'expression'
     * @param string $select
     * @return $this chain
     */
    public function select($select)
    {
        $this->criteria->select = $select;
        $this->client->SetSelect($select);
        return $this;
    }

    /**
     * @brief set index name for search, SQL-like syntax - 'table_reference'
     * @param string $index
     * @return $this chain
     */
    public function from($index)
    {
        $this->criteria->from = $index;
        return $this;
    }

    /**
     * @brief set search query, SQL-like syntax - 'where_condition'
     * @param string $query
     * @return $this chain
     */
    public function where($query)
    {
        $this->criteria->query = $query;
        return $this;
    }

    /**
     * @brief set query filters, SQL-like syntax - 'additional where_condition'
     * @param array $filters
     * @return $this chain
     */
    public function filters($filters)
    {
        $this->criteria->filters = $filters;
        //set filters
        if ($filters && is_array($filters)) {
            foreach ($filters as $fil => $vol) {
                // geo filter
                if ($fil == 'geo') {
                    $min = (float) (isset($vol['min']) ? $vol['min'] : 0);
                    $point = explode(' ', str_replace('POINT(', '', trim($vol['point'], ')')));
                    $this->client->setGeoAnchor('latitude', 'longitude', (float) $point[1] * ( pi() / 180 ), (float) $point[0] * ( pi() / 180 ));
                    $this->client->setFilterFloatRange('@geodist', $min, (float) $vol['buffer']);
                    // usual filter
                } else if ($vol) {
                    $this->client->SetFilter($fil, (is_array($vol)) ? $vol : array($vol));
                }
            }
        }
        return $this;
    }

    /**
     * @brief set grouping attribute and function, SQL-like syntax - 'group_by'
     * @param array $groupby
     * @return $this chain
     */
    public function groupby($groupby = null)
    {
        $this->criteria->groupby = $groupby;
        // set groupby
        if ($groupby && is_array($groupby)) {
            $this->client->setGroupBy($groupby['field'], $groupby['mode'], $groupby['order']);
        }
        return $this;
    }

    /**
     * @brief set matches sorting, SQL-like syntax - 'order_by expression'
     * @param DGSort $orders
     * @return $this chain
     */
    public function orderby(DGSort $orders = null)
    {
        $this->criteria->orders = $orders;
        if ($orders && $orders->getOrderBy()) {
            $this->client->SetSortMode(SPH_SORT_EXTENDED, $orders->getOrderBy());
        }
        return $this;
    }

    /**
     * @brief set offset and count into result set, SQL-like syntax - 'limit $offset, $count'
     * @param integer $offset
     * @param integer $limit
     * @return $this chain
     */
    public function limit($offset=null, $limit=null)
    {
        $this->criteria->limit = array(
            'offset' => $offset,
            'limit' => $limit
        );
        if (isset($offset) && isset($limit)) {
            $this->client->setLimits($offset, $limit);
        }
        return $this;
    }

    /**
     * @brief returns errors if any
     */
    public function getLastError()
    {
        return $this->client->getLastError();
    }

    /**
     * @brief reset search criteria to default
     * @details reset conditions and set default search options
     */
    public function resetCriteria()
    {
        if (is_object($this->criteria)) {
            $this->lastCriteria = clone($this->criteria);
        } else {
            $this->lastCriteria = new stdClass();
        }
        $this->criteria = new stdClass();
        $this->criteria->query = '';
        $this->client->resetFilters();
        $this->client->resetGroupBy();
        $this->client->setArrayResult(false);
        $this->client->setMatchMode($this->matchMode);
        $this->client->setRankingMode($this->rankMode);
        $this->client->setSortMode(SPH_SORT_RELEVANCE, '@relevance DESC');
        $this->client->setLimits(0, 1000000, 2000);
        if (!empty($this->fieldWeights)) {
            $this->client->setFieldWeights($this->fieldWeights);
        }
    }

    /**
     * @brief handle given search criteria. set them to current object
     * @param object $criteria
     */
    public function setCriteria($criteria)
    {
        if (!is_object($criteria)) {
            throw new DGSphinxSearchException('Criteria does not set.');
        }
        if (isset($criteria->paginator)) {
            if (!is_object($criteria->paginator)) {
                throw new DGSphinxSearchException('Criteria paginator invalid.');
            }
            $this->limit($criteria->paginator->getOffset(), $criteria->paginator->getLimit());

            $this->criteria->paginator = $criteria->paginator;
        }

        // set select expression
        if (isset($criteria->select)) {
            $this->select($criteria->select);
        }
        // set from criteria
        if (isset($criteria->from)) {
            $this->from($criteria->from);
        }
        // set where criteria
        if (isset($criteria->query)) {
            $this->where($criteria->query);
        }
        // set grouping
        if (isset($criteria->groupby)) {
            $this->groupby($criteria->groupby);
        }
        // set filters
        if (isset($criteria->filters)) {
            $this->filters($criteria->filters);
        }

        // set field ordering
        if (isset($criteria->orders) && $criteria->orders) {
            $this->orderby($criteria->orders);
        }
    }

    /**
     * @brief get current search criteria
     * @return object criteria
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @brief magic for wrap SphinxClient functions
     * @param string $name
     * @param array $parameters
     * @return DGSphinxSearch
     */
    public function __call($name, $parameters)
    {
        $res = null;
        if (method_exists($this->client, $name)) {
            $res = call_user_func_array(array($this->client, $name), $parameters);
        } else {
            $res = parent::__call($name, $parameters);
        }
        // if setter or resetter then return chain
        if (strtolower(substr($name, 0, 3)) === 'set' || strtolower(substr($name, 0, 5)) === 'reset') {
            $res = $this;
        }
        return $res;
    }

    /**
     * @brief Performs actual query through Sphinx Connector
     * @details Profiles $this->client->query($query, $index);
     * @param string $index
     * @param string $query
     * @param string $comment
     * @return array
     */
    protected function doSearch($index, $query = '', $comment = '')
    {
        if (!$index) {
            throw new DGSphinxSearchException('Index search criteria invalid');
        }

        if ($this->enableResultTrace) {
            Yii::trace("Query '$query' is performed for index '$index'", 'CEXT.DGSphinxSearch.doSearch');
        }

        if ($this->enableProfiling) {
            Yii::beginProfile("Search query: '{$query}' in index: '{$index}'", 'CEXT.DGSphinxSearch.doSearch');
        }

        $res = $this->client->query($query, $index, $comment);

        if ($this->getLastError()) {
            throw new DGSphinxSearchException($this->getLastError());
        }

        if ($this->enableProfiling) {
            Yii::endProfile("Search query: '{$query}' in index: '{$index}'", 'CEXT.DGSphinxSearch.doSearch');
        }

        if ($this->enableResultTrace) {
            Yii::trace("Query result: " . substr(print_r($res, true), 500), 'CEXT.DGSphinxSearch.doSearch');
        }

        if (!isset($res['matches'])) {
            $res['matches'] = array();
        }
        $this->resetCriteria();
        return $res;
    }

    /**
     * @brief full text search system query by given criteria object
     * @details send query to full text search system
     * @param object criteria
     * @return array
     */
    protected function searchByCriteria($criteria)
    {
        if (!is_object($criteria)) {
            throw new DGSphinxSearchException('Criteria does not set.');
        }

        // handle given criteria
        $this->setCriteria($criteria);

        // process search
        $res = $this->doSearch($this->criteria->from, $this->criteria->query);

        //ugly hack
        if (isset($criteria->paginator)&&$criteria->paginator) {
            if (isset($res['total'])) {
                $criteria->paginator->setItemCount($res['total']);
            } else {
                $criteria->paginator->setItemCount(0);
            }
        }

        return $res;
    }

    /**
     * @brief init DGSphinxSearchResult interator for search results
     * @param array $data
     * @param stdObject $criteria
     * @return DGSphinxSearchResult
     */
    protected function initIterator(array $data, $criteria = NULL)
    {
        $iterator = new DGSphinxSearchResult($data, $criteria);
        $iterator->enableProfiling = $this->enableProfiling;
        $iterator->enableResultTrace = $this->enableResultTrace;
        return $iterator;
    }

}
